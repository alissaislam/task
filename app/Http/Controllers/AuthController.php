<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    /**
     * Show registration form
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->userService->register($request->validated());
        
        Auth::login($user);
        
        return redirect()->route('user.tasks.index')
            ->with('success', 'Registration successful! Welcome to Task Management System.');
    }

    /**
     * Show login form
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('user.tasks.index'))
                ->with('success', 'Login successful! Welcome back.');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}