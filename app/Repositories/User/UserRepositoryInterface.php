<?php

declare(strict_types=1);

namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getListUsersPagination(Request $request);
}