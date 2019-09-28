<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Validators\UserValidator;
use App\Traits\TraitBaseController;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends Controller
{
    use TraitBaseController;

    public function __construct (UserRepository $repo, UserValidator $userValidator) {
        $this->repository = $repo;
        $this->validator = $userValidator;

        $this->views = [
            'index'  => 'users.index',
            'edit'   => 'users.edit',
            'show'   => 'users.show',
            'create' => 'users.create',
        ];
    }

    public function list () {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $result = $this->repository->allWithRole('reseller');

        return response()->json([
            'result' => $result,
        ]);
    }

    public function store (Request $request) {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $request->merge([
                'password' => Hash::make($request->get('password'))
            ]);

            $result = $this->repository->create($request->all());

            info('role: ' . $request->get('role'));
            if ($request->has('role')) {
                $role = Role::where('name', $request->get('role'))->first();
                $result->roles()->attach($role->id);
            }

            $response = [
                'message' => 'created.',
                'data'    => $result->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect(route('users.index'));
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
}
