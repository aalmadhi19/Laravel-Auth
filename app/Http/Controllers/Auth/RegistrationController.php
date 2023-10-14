<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Repositories\Interfaces\IUserRepository;
use PhpParser\Node\Stmt\TryCatch;

class RegistrationController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showRegistrationForm()
    {
        return view('auth.registration');
    }

    public function register(RegistrationRequest $request)
    {
        
        $this->userRepository->create($request->validated());
        return redirect()->route("login");
    }
}
