<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserServiceInterface {
    public function createUser(Request $request): User;
    public function login(Request $request): string | null;
}
