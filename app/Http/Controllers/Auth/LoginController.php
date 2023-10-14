<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLoginForm(Request $request)
    {
        return view("Auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = $this->userRepository->findByEmail($credentials['email']);

        if ($user && $this->userRepository->validateCredentials($user, $credentials['password'])) {
            auth()->login($user);
            return redirect()->intended('/');
        }
        return redirect()->back()->with(['error' => 'Invalid login credentials']);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
