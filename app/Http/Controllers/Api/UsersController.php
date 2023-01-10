<?php

namespace App\Http\Controllers\Api;

use Auth;
use Response;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);

        // return Response::json($users);
        return UsersResource::collection($users);
    }

    public function user($iduser)
    {
        $user = User::find($iduser);

        if ($user == null) {
            return Response::json([
                'status' => [
                    'code' => 404,
                    'description' => 'Data User Not Found'
                ]
            ]);
        }

        return (new UsersResource($user))->additional([
            'status' => [
                'code' => 200,
                'description' => 'Ok'
            ]
        ])->response()->setStatusCode(200);
    }

    public function login(Request $request)
    {
        // return $request->all();

        if ( ! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return Response::json([
                'status' => [
                    'code' => 401,
                    'description' => 'Credential is wrong',
                ]
            ], 401);
        }

        $loginUser = Auth::user();

        return (new UsersResource($loginUser))->additional([
            'status' => [
                'code' => 202,
                'description' => 'Accepted',
            ]
        ])->response()->setStatusCode(202);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5'
        ]);

        $newUsers = User::create([
                'name' => $request->name,
                'username' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => bcrypt($request->name),
            ]);

            return (new UsersResource($newUsers))->additional([
                'status' => [
                    'code' => 201,
                    'description' => 'User Created',
                ]
            ])->response()->setStatusCode(201);
    }

    public function update(Request $request, $iduser)
    {
        $request->validate([
            'name' => 'max:120',
            'username' => 'max:100|unique:users,id,'.$iduser,
            'email' => 'email|unique:users,id,'.$iduser,
        ]);

        $user = User::find($iduser);

        if($user == null){
            return Response::json([
                'status' => [
                    'code' => 404,
                    'description' => 'User Not Found'
                ]
            ],404);
        } else {
            $request->merge([
                'password' => bcrypt($request->password),
            ]);

            $user->update($request->all());
        }

        return (new UsersResource($user))->additional([
            'status' => [
                'code' => 202,
                'description' => 'Update Successfully'
            ]
        ])->response()->setStatusCode(202);
    }
}
