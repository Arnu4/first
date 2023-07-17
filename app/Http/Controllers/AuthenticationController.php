<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ShowUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\AuthorizationServer;

class AuthenticationController extends Controller
{
    private $server, $tokens;

    public function __construct(AuthorizationServer $server,
                                TokenRepository $tokens)
    {
        $this->server = $server;
        $this->tokens = $tokens;
    }
    public function register(RegisterRequest $request){
        try {
            DB::beginTransaction();
            $user = User::query()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
            Auth::login($user);
//            return response()->json($user->createToken('UserAuthApp'));
            $token = $user->createToken('UserAuthApp')->accessToken;
            DB::commit();
            $data = new ShowUserResource($user);
            return Response::success_message('test' , [$data,'Bearer' , $token]);
        }catch (\Exception $e) {
            DB::rollBack();
            return Response::error($e->getMessage(), 500);
//        return Response::success_message('test' , $request->all(),ShowUserResource $resource_obj);
        }
    }

    public function login(LoginRequest $request)
    {
//        $token = AccessTokenController::issueToken($request);
        $token = new AccessTokenController($this->server,$this->tokens);
        $token->issueToken($request);
        return $token;
    }
}
