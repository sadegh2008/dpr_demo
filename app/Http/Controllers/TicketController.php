<?php

namespace App\Http\Controllers;

use App\Jobs\TicketProcess;
use App\Repositories\TicketMessageRepository;
use App\Traits\TraitBaseController;
use App\Validators\TicketValidator;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class TicketController extends Controller
{
    use TraitBaseController;

    protected $msgRepo;

    public function __construct (TicketRepository $repo, TicketMessageRepository $msgRepo, TicketValidator $ticketValidator) {
        $this->repository = $repo;
        $this->validator = $ticketValidator;

        $this->msgRepo = $msgRepo;

        $this->views = [
            'index'  => 'tickets.index',
            'show'   => 'tickets.show',
            'edit'   => 'tickets.edit',
            'create' => 'tickets.create'
        ];
    }

    public function _index ($filters, $view) {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $result = $this->repository->with(['creator'])->findWhere($filters)->all();

        if (request()->wantsJson()) {

            return response()->json([
                'result' => $result,
            ]);
        }

        return view($this->views['index'], compact('result'));
    }

    public function index () {
        return $this->_index(['delete_status' => 'none'], 'tickets.index');
    }

    public function waitForDestroy () {
        return $this->_index(['delete_status' => 'wait'], 'tickets.wait_for_destroy');
    }

    public function store (Request $request) {
        try {
            if ($this->formRequest)
                app($this->formRequest);

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);


            return \DB::transaction(function () use ($request) {
                $ticket = $this->repository->create($request->all());

                // add message to belonged table
                $this->msgRepo->create([
                    'message'   => $request->message,
                    'ticket_id' => $ticket->id
                ]);

                $response = [
                    'message' => 'created.',
                    'data'    => $ticket->toArray(),
                ];

                dispatch(new TicketProcess($ticket))->delay(now()->addMinutes(5));

                if ($request->wantsJson()) {

                    return response()->json($response);
                }

                return redirect()->back()->with('message', $response['message']);
            });
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => TRUE,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function show($id)
    {
        $result = $this->repository->with(['creator', 'messages'])->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $result,
            ]);
        }

        return view($this->views['show'], compact('result'));
    }

    public function assignUser (Request $request, $ticket_id) {
        $request->validate(['user_id' => 'required']);
        $this->repository->assignUser($ticket_id, $request->user_id);
        return redirect()->back()->with('message', 'assigned');
    }

    public function destroy ($id) {
        if (auth()->user()->can('confirm_delete_ticket')) {
            $deleted = $this->repository->delete($id);
        } else {
            $this->repository->update(['delete_status' => 'wait'], $id);
            $deleted = 1;
        }

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'deleted.');
    }
}
