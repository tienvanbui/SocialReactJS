<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\Filters\UserFilter;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $model) {}

    public function getListUsersPagination(Request $request)
    {
        return $this->model::filters(new UserFilter($request))->latest()->paginate(config('const.pagination'));
    }
}
