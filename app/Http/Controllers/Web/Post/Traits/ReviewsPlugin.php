<?php


namespace App\Http\Controllers\Web\Post\Traits;

trait ReviewsPlugin
{
	private string $postHelperClass = '\extras\plugins\reviews\app\Helpers\Post';
	
	/**
	 * @param $postId
	 * @return array
	 */
	public function getReviews($postId): array
	{
		if (config('plugins.reviews.installed')) {
			if (class_exists($this->postHelperClass)) {
				return $this->postHelperClass::getReviews($postId);
			}
		}
		
		return [];
	}
}
