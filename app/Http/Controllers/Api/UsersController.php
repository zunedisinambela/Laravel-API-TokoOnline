<?php

namespace App\Http\Controllers\Api;

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
}
