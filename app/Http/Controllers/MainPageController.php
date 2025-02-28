<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Services\Games\LuckyNumberService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MainPageController extends Controller
{

    private UserService $userService;

    private LuckyNumberService $luckyNumberService;

    public function __construct(
        UserService $userService,
        LuckyNumberService $luckyNumberService
    )
    {
        $this->userService = $userService;
        $this->luckyNumberService = $luckyNumberService;
    }

    public function index()
    {
        return view('main_page');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->getUser($request->name, $request->phone);
        $activeLink = $this->luckyNumberService->getActiveLink($user);

        return "Your link: " . $activeLink;
    }
}
