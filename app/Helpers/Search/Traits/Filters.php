<?php


namespace App\Helpers\Search\Traits;

use App\Helpers\Search\Traits\Filters\AuthorFilter;
use App\Helpers\Search\Traits\Filters\CategoryFilter;
use App\Helpers\Search\Traits\Filters\CustomFieldsFilter;
use App\Helpers\Search\Traits\Filters\DateFilter;
use App\Helpers\Search\Traits\Filters\DynamicFieldsFilter;
use App\Helpers\Search\Traits\Filters\KeywordFilter;
use App\Helpers\Search\Traits\Filters\LocationFilter;
use App\Helpers\Search\Traits\Filters\PostTypeFilter;
use App\Helpers\Search\Traits\Filters\PriceFilter;
use App\Helpers\Search\Traits\Filters\TagFilter;

trait Filters
{
	use AuthorFilter, CategoryFilter, KeywordFilter, LocationFilter, TagFilter,
		DateFilter, PostTypeFilter, PriceFilter, DynamicFieldsFilter, CustomFieldsFilter;
	
	protected function applyFilters()
	{
		if (!(isset($this->posts))) {
			return;
		}
		
		// Default Filters
		$this->posts->currentCountry()->verified()->unarchived();
		if (config('settings.single.listings_review_activation')) {
			$this->posts->reviewed();
		}
		
		// Author
		$this->applyAuthorFilter();
		
		// Category
		$this->applyCategoryFilter();
		
		// Keyword
		$this->applyKeywordFilter();
		
		// Location
		$this->applyLocationFilter();
		
		// Tag
		$this->applyTagFilter();
		
		// Date
		$this->applyDateFilter();
		
		// Listing Type
		$this->applyPostTypeFilter();
		
		// Price
		$this->applyPriceFilter();
		
		// Dynamic Fields
		$this->applyDynamicFieldsFilters();
		
		// Custom Fields
		$this->applyCustomFieldsFilter();
	}
}
