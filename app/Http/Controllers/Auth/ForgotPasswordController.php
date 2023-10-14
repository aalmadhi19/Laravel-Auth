<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLinkRequestForm()
    {
        return view('auth.password.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);

        if ($user) {

            $this->userRepository->generatePasswordResetToken($user);

            Mail::to($user->email)->send(new ResetPasswordMail($user));

            return redirect()->route('login')->with('message', 'Password reset email sent. Please check your email');
        }

        return redirect()->back()->withErrors(['email' => 'Email not found.']);
    }

    protected function showResetForm(Request $request)
    {
        return view('auth.password.reset-password', [
            'token' => $request->token,
        ]);
    }

    public function updatePassword(ForgotPasswordRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);
        if ($user) {

            $validToken = $this->userRepository->validateToken($user, $request->token);

            if ($validToken) {
                $this->userRepository->resetPassword($user, $request->password);
                return redirect()->route('login')->with('message', 'Password reseted.');
            } else {
                return redirect()->back()->with(['error' => 'Invalid token', 'token' => $request->token]);
            }
        }
        return redirect()->back()->withErrors(['email' => 'Email not found.']);
    }
}
