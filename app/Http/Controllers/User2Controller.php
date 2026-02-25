<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use App\Services\User2Service;

class User2Controller extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the User2 Microservice
     * @var User2Service
     */
    public $user2Service;

    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(User2Service $user2Service)
    {
        $this->user2Service = $user2Service;
    }

    public function index()
    {
        return $this->successResponse($this->user2Service->obtainUsers2());
    }

    /**
     * Wrapper for instructor-style method name `add`.
     */
    public function add(Request $request)
    {
        return $this->store($request);
    }

    public function show($id)
    {
        return $this->successResponse($this->user2Service->obtainUser2($id));
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request, $rules);

        try {
            $response = $this->user2Service->createUser2($request->all());
            return $this->successResponse($response, \Illuminate\Http\Response::HTTP_CREATED);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return $this->errorResponse('Username already exists', \Illuminate\Http\Response::HTTP_CONFLICT);
            }
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        return $this->successResponse($this->user2Service->editUser2($request->all(), $id));
    }

    public function destroy($id)
    {
        return $this->successResponse($this->user2Service->deleteUser2($id));
    }
}
