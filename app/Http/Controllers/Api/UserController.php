<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\http\Resources\UserCollection;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserCollection::make(User::all());
    }

    /**
     * Display a listing of the resource.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',  
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
     
        $user->save();

        return response()->json(new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string', 
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password; 

        $user->save();

       
        return response()->json(new UserResource($user));
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User   $user)
    {
        $user-> delete();

        return response()->json(null,204);
    }
}
