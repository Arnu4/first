<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function signInWithGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function callbackToGoogle(){
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::query()->where('gauth_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/dashboard');

            }else{
                $newUser = User::query()->create([
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'gauth_id'=> $user->id,
                    'gauth_type'=> 'google',
                    'password' => encrypt('admin@123')
                ]);

                Auth::login($newUser);

                return redirect('/dashboard');
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
//            dd($e->getMessage());
        }
    }
}
