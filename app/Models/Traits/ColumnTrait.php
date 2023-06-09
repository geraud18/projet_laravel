<?php


namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ColumnTrait
{
	/**
	 * columnIsEmpty()
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder
	 * @param string $column
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeColumnIsEmpty(Builder $builder, string $column): Builder
	{
		$builder->where(function ($query) use ($column) {
			$query->where($column, '')->orWhere($column, 0)->orWhereNull($column);
		});
		
		return $builder;
	}
	
	/**
	 * columnIsNotEmpty()
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder
	 * @param string $column
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeColumnIsNotEmpty(Builder $builder, string $column): Builder
	{
		$builder->where(function ($query) use ($column) {
			$query->where($column, '!=', '')->where($column, '!=', 0)->whereNotNull($column);
		});
		
		return $builder;
	}
}
