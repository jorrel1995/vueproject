<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {}

    public function view(string $page)
    {
        $page = Str::ucfirst($page);

        return Inertia::render($page);
    }

    public function dashboard()
    {

        $userCount = \App\Models\User::count();

        return Inertia::render('Dashboard', [
            'userCount' => $userCount,
        ]);
    }
}
