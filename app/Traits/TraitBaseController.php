<?php


namespace App\Traits;

use App\Validators\TestValidator;
use App\Http\Requests\TestCreateRequest;
use App\Http\Requests\TestUpdateRequest;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

trait TraitBaseController
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var TestValidator
     */
    protected $validator;

    /**
     * @var FormRequest
     */
    protected $formRequest;

    /**
     * @var Views
     *
     * Example:
     * [
     *    index => 'ticket.index',
     *    edit  => 'ticket.edit',
     *    ......
     * ]
     */
    protected $views;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $result = $this->repository->paginate();

        if (request()->wantsJson()) {

            return response()->json([
                'result' => $result,
            ]);
        }

        return view($this->views['index'], compact('result'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {
            if ($this->formRequest)
                app($this->formRequest);

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $test = $this->repository->create($request->all());

            $response = [
                'message' => 'created.',
                'data'    => $test->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->views['create']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $result,
            ]);
        }

        return view($this->views['show'], compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->repository->find($id);

        return view($this->views['edit'], compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(Request $request, $id)
    {
        try {
            if ($this->formRequest)
                app($this->formRequest);

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $result = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'updated.',
                'data'    => $result->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'deleted.');
    }


}
