<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use App\Helpers\HttpResponseHelper;
use App\Http\Requests\User\UserLogin;

class UserController extends Controller
{
    public function login(UserLogin $request)
    {
        $credentials = $request->only('email', 'password');

        // Fetch the user by email
        $user = User::where('email', $credentials['email'])->first();

        // Check if the user exists
        if (!$user) {
            return HttpResponseHelper::error('Sorry, we could not find you.', 400);
        }

        // Attempt to create a token with the provided credentials
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return HttpResponseHelper::error('Invalid credentials.', 400);
            }
        } catch (JWTException $e) {
            // Return an error response
            return HttpResponseHelper::error('Could not create token.', 500);
        }

        // Return the token

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            return HttpResponseHelper::success([
                'access_token' => $token,
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
                'user' => Auth::guard('api')->user()
            ], 'Users authenticated successfully.');
        } else {
            return HttpResponseHelper::error('Invlid credentials,Please check your email and password', 401);
        }
    }

    /**
     * Logout the user and invalidate the token.
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken()); // Invalidate the token
            return HttpResponseHelper::success([], 'User logged out successfully.');
        } catch (\Exception $e) {
            return HttpResponseHelper::error('Failed to logout.', 500);
        }
    }
}
