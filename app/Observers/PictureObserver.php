<?php


namespace App\Observers;

use App\Models\Language;
use App\Models\Picture;
use App\Models\Scopes\ActiveScope;
use App\Observers\Traits\PictureTrait;

class PictureObserver
{
	use PictureTrait;
	
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function deleting(Picture $picture)
	{
		// Delete all pictures files
		if (isset($picture->filename)) {
			$this->removePictureWithItsThumbs($picture->filename);
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function saved(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function deleted(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $picture
	 */
	private function clearCache($picture)
	{
		try {
			cache()->forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id);
			cache()->forget('post.with.city.pictures.' . $picture->post_id);
			
			// Need to be caught (Independently)
			$languages = Language::withoutGlobalScopes([ActiveScope::class])->get(['abbr']);
			
			if ($languages->count() > 0) {
				foreach ($languages as $language) {
					cache()->forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id . '.' . $language->abbr);
					cache()->forget('post.with.city.pictures.' . $picture->post_id . '.' . $language->abbr);
				}
			}
		} catch (\Throwable $e) {
		}
	}
}
