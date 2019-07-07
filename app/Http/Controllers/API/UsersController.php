<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display all users in desc order
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => User::orderBy('id', 'desc')->get()]);
    }

    /**
     * Create a new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::create(\request(['first_name', 'last_name', 'email', 'password']));
        return response()->json(['data' => $user], 201);
    }

    /**
     * Show single user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(['data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'password' => 'min:6',
            'email' => 'email',
        ];

        $request->validate($rules);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;

        if ($request->has('password')) {
            $user->password = $request->password;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['data' => $user], 200);
    }
}
