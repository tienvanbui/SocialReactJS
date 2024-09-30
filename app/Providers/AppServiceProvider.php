<?php

namespace App\Providers;

use App\Models\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::macro('filters', function (Filters $filters) {
            return $filters->getQuery($this);
        });

        Builder::macro('whereLike', function ($column, $value, $filter = false) {

            $escaped = str_replace(['\\', '_', '%'], ['\\\\', '\\_', '\\%'], $value);

            $isJapanese = preg_match('/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $value);

            if ($isJapanese && !Str::contains($column, '->') && $filter == true) {
                return $this->where($column, 'LIKE', "%$escaped%");
            } elseif ($isJapanese && !Str::contains($column, '->')) {
                return $this->where(\DB::raw("BINARY `$column`"), 'LIKE', "%$escaped%");
            } else {
                return $this->where($column, 'LIKE', "%$escaped%");
            }
        });

        Builder::macro('orWhereLike', function ($column, $value, $filter = false) {
            $escaped = str_replace(['\\', '_', '%'], ['\\\\', '\\_', '\\%'], $value);

            $isJapanese = preg_match('/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u', $value);

            if ($isJapanese && !Str::contains($column, '->') && $filter == true) {
                return $this->orWhere($column, 'LIKE', "%$escaped%");
            } elseif ($isJapanese && !Str::contains($column, '->')) {
                return $this->orWhere(\DB::raw("BINARY `$column`"), 'LIKE', "%$escaped%");
            } else {
                return $this->orWhere($column, 'LIKE', "%$escaped%");
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::loginUsingId(1);
    }
}
