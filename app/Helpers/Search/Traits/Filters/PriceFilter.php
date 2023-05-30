<?php


namespace App\Helpers\Search\Traits\Filters;

trait PriceFilter
{
	protected function applyPriceFilter()
	{
		// The 'calculatedPrice' is a calculated column, so HAVING clause is required
		if (!isset($this->having)) {
			return;
		}
		
		$minPrice = null;
		$maxPrice = null;
		if (request()->filled('minPrice')) {
			$minPrice = request()->get('minPrice');
		}
		if (request()->filled('maxPrice')) {
			$maxPrice = request()->get('maxPrice');
		}
		
		$minPrice = (is_numeric($minPrice)) ? $minPrice : null;
		$maxPrice = (is_numeric($maxPrice)) ? $maxPrice : null;
		
		if (!is_null($minPrice) && !is_null($maxPrice)) {
			if ($maxPrice > $minPrice) {
				$this->having[] = 'calculatedPrice >= ' . $minPrice;
				$this->having[] = 'calculatedPrice <= ' . $maxPrice;
			}
		} else {
			if (!is_null($minPrice)) {
				$this->having[] = 'calculatedPrice >= ' . $minPrice;
			}
			if (!is_null($maxPrice)) {
				$this->having[] = 'calculatedPrice <= ' . $maxPrice;
			}
		}
	}
}
