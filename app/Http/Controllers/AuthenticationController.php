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
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\AuthorizationServer;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationController extends Controller
{
    use HandlesOAuthErrors;

    /**
     * The authorization server.
     *
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    private $server;

    /**
     * The token repository instance.
     *
     * @var \Laravel\Passport\TokenRepository
     */
    private $tokens;

    /**
     * Create a new controller instance.
     *
     * @param  \League\OAuth2\Server\AuthorizationServer  $server
     * @param  \Laravel\Passport\TokenRepository  $tokens
     * @return void
     */
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


    /**
     * Authorize a client to access the user's account.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface  $request
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
//            public function issueToken(LoginRequest $request)
    {
//        $token = AccessTokenController::issueToken($request);
//        return response()->json($request->all());
//        $token = new AccessTokenController($this->server,$this->tokens);
//        return $token->issueToken($request);
        return $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }

    public function login(LoginRequest $request){
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return Response::error('Invalid email or password', 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('api_token');
        $accessToken = $tokenResult->accessToken;
//        $refreshToken = $tokenResult->refreshToken();
        $refreshToken = 'l;l';
        $data = [
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
        return Response::success_message('login is successfully',$data);
    }

}
