<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'data.attributes.name'=>['required','string','min:4'],
            'data.attributes.email'=>['required','email','lowercase','unique:users,email'],
            'data.attributes.password'=>['required','confirmed'],
            // 'data.attributes.password'=[
            // 'required',
            // 'string',
            // 'min:8',
            // 'regex:/[a-z]/',
            // 'regex:/[A-Z]/',
            // 'regex:/[a-z]/',
            // ],
        ]);
            $user = User::create([
                'name'=>$request->input('data.attributes.name'),
                'email'=>$request->input('data.attributes.email'),
                'password'=>$request->input(('data.attributes.password')),
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user'=> $user,
                'token'=> $token
            ]);
    }


    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'data.attributes.email' => ['required', 'email', 'exists:users,email'],
            'data.attributes.password' => ['required', 'string'],
        ]);
        
        $credentials = [
            'email' => $request->input('data.attributes.email'),
            'password' => $request->input('data.attributes.password')
        ];
        
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
