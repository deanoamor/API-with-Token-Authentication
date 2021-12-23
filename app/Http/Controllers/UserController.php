<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $hashpass = Hash::make($password);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $hashpass,
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'Status' => 'success',
                'Message' => 'Register berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'Data' => $user,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'Status' => 'error',
                'Message' => 'Ada yang salah',
                'error' => $error,
            ]);
        }
    }

    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'Status' => 'error',
                    'Message' => 'Login gagal',
                ]);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'Status' => 'success',
                'Message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'Data' => $user,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'Status' => 'error',
                'Message' => 'Tidak dapat akses',
                'error' => $error,
            ]);
        }
    }

    public function logout(Request $request)
    {

        $token = $request->user()->currentAccessToken()->delete();
        return response()->json([
            'Token' => $token,
            'Message' => 'Token terhapus',
        ]);
    }
}
