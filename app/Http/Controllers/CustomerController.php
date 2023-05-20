<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerController extends BaseController
{
    /**
     * Register Customer
     *
     * @param StoreCustomerRequest $request
     * @return JsonResponse
     */
    public function register(StoreCustomerRequest $request): JsonResponse
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);

        $user = User::query()->create($input);

        return $this->success(
            ['token' => $user->createToken($request->name)->plainTextToken],
            'User register successfully.',
            201
        );
    }

    /**
     * Login Customer
     *
     * @param LoginCustomerRequest $request
     * @return JsonResponse
     */
    public function login(LoginCustomerRequest $request): JsonResponse
    {
         $user = User::query()->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->success(
            ['token' => $user->createToken($request->email)->plainTextToken],
            'Logged in successfully.'
        );
    }
}
