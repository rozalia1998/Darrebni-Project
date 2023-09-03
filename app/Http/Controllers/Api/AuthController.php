<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Code;
use App\Http\Traits\JsonResponse;
use App\Services\UserService;
use Exception;

class AuthController extends Controller
{
    use JsonResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request){
        try{
            $user=$this->userService->newRegister($request->all());
            $token=$user->createToken('ApiToken')->plainTextToken;
            return $this->successResponse('User Registered Successfully', $token);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function login(LoginRequest $request){

        $credentials = $request->only('name', 'login_code');

        $user = User::where('name', $credentials['name'])->first();

        if ($user && $user->code && $user->code->login_code === $credentials['login_code']) {
            $token = $user->createToken('ApiToken')->plainTextToken;
            $user->update(['fcm_token' => $request->fcm_token]);
            $data = [
                'token'=>$token,
                'name' => $user->name,
                'mobile_phone' => $user->mobile_phone,
                'specialization_id' => $user->code->specialization_id,
            ];
            return $this->successResponse('Login Success', $data);
        } else {
            return $this->errorResponse('Invalid Information', 401);
        }
    }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        return $this->successResponse('user logged out');
    }
}
