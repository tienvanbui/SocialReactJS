<?php

namespace App\Models\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter extends Filters
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function getQuery(Builder $query): Builder
	{
		$this->filterByKeyword($query);
		return $query;
	}

	public function filterByKeyword(Builder $builder): void
	{
		$keyword = $this->request->keyword;

		$check = (!empty($keyword) || $keyword == '0') ? true : false;

		$builder->when($check, function ($q) use ($keyword) {
			$q->whereLike('name', $keyword);
		});
	}
}
