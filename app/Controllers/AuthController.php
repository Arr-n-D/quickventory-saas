<?php

namespace App\Controllers;

use App\Http\Controllers\Controller;
use App\Requests\RegisterRequest;
use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\RefreshTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\PassportToken;
use App\Traits\IssueTokenTrait;
use Laravel\Passport\Client;
use App\Models\Customer;

/**
 * [Description AuthController]
 */
class AuthController extends Controller
{

    use PassportToken, IssueTokenTrait;

    /**
     * @var Client
     */
    private Client $client;
    protected $model = User::class;

    public function __construct()
    {
        $this->client = Client::where('personal_access_client', false)->firstOrFail();
    }

    /**
     * @param RegisterRequest $request
     * 
     * @return [type]
     */
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();
            /** @var User $user */
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => \bcrypt($validated['password']),
                'date_of_birth' => $validated['date_of_birth']
            ]);
            /** @var Customer $customer */
            $customer = $user->customers()->create([
                'customer_name' => $validated['email'],
            ]);
            $customer->domains()->create([
                'domain' => 'cominar'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return $this->errorResponse();
        }

        return $this->getBearerTokenByUser($user->refresh(), $this->client->id);
    }

    /**
     * @param LoginRequest $request
     * 
     * @return [type]
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $username = $validated['username'];
        $password = $validated['password'];
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            Auth::attempt(['username' => $username, 'password' => $password]);
        }

        if (Auth::check()) {
            return $this->issueToken($request, 'password', '*');
        }

        return $this->errorResponse([
            'message' => 'Invalid credentials'
        ]);
    }

    /**
     * @param RefreshTokenRequest $request
     * 
     * @return [type]
     */
    public function refresh(RefreshTokenRequest $request)
    {
        return $this->issueToken($request, 'refresh_token', '*');
    }
}
