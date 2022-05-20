<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function authenticate()
    {
        $this->configureRateLimiting();

        $credentials = $this->only('email', 'password');

        if (! Auth::attempt($credentials)) {

        RateLimiter::hit($this->input('email'), 60);

        throw ValidationException::withMessages(['error' => 'Email atau Password salah. Silahkan coba kembali!']);

        }
    }

    public function configureRateLimiting()
    {
        $input = $this->input('email') ?: $this->ip();

        if (! RateLimiter::tooManyAttempts($input, 2)) {
            return;
    }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($input);

        throw ValidationException::withMessages(['error' => 'Upaya masuk dibatasi. Coba kembali setelah ' . $seconds  . ' detik.']);
    }
}
