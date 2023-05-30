<?php


namespace App\Helpers\Search\Traits\Relations;

trait CategoryRelation
{
	protected function setCategoryRelation()
	{
		if (!(isset($this->posts) && isset($this->postsTable))) {
			abort(500, 'Fatal Error: Category relation cannot be applied.');
		}
		
		// category
		$this->posts->with(['category' => function ($query) {
			$query->with('parent');
		}]);
		
		if (!request()->filled('q')) {
			
			$this->posts->has('category');
			
		} else {
			
			$this->posts->join('categories as tCategory', function ($join) {
				$join->on('tCategory.id', '=', $this->postsTable . '.category_id')
					->where('tCategory.active', 1);
			});
			$this->posts->leftJoin('categories as tParentCat', function ($join) {
				$join->on('tParentCat.id', '=', 'tCategory.parent_id')
					->where('tParentCat.active', 1);
			});
			
		}
	}
}
