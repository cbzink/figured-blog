<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthorResource;

class AuthorController extends Controller
{
    /**
     * Returns the currently authenticated author.
     *
     * @return App\Http\Resources\AuthorResource
     */
    public function showMe()
    {
        return new AuthorResource(Auth::user());
    }
}
