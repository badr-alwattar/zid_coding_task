<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];
        dd($data);
        $user = User::create($data);
        $user->assignRole(Role::findOrFail($request->role_id)->name);
        
        return response()->json(['message' => 'Successfully created user!'], 201);
    }
}
