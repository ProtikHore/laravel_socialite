<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $loginData = $request->except('_token', 'confirmed');
        $loginData['password'] = sha1($loginData['password']);
        $user = User::where($loginData)->first();
        if ($user) {
            session([
                'login_status' => true,
                'id' => $user->id,
                'name' => $user->name
            ]);
            return response()->json('Authorized User');
        } else {
            return response()->json('Unauthorized Access!');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                session([
                    'login_status' => true,
                    'id' => $user->id,
                    'name' => $user->name
                ]);

                return redirect('/user');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => sha1('123')
                ]);

                session([
                    'login_status' => true,
                    'id' => $user->id,
                    'name' => $user->name
                ]);

                return redirect('/user');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
