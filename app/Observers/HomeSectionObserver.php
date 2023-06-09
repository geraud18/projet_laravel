<?php


namespace App\Observers;

use App\Helpers\Files\Storage\StorageDisk;
use App\Models\HomeSection;

class HomeSectionObserver
{
	/**
	 * Listen to the Entry updating event.
	 *
	 * @param HomeSection $homeSection
	 * @return void
	 */
	public function updating(HomeSection $homeSection)
	{
		if (isset($homeSection->method) && isset($homeSection->value)) {
			// Get the original object values
			$original = $homeSection->getOriginal();
			
			// Storage Disk Init.
			$disk = StorageDisk::getDisk();
			
			if (is_array($original) && array_key_exists('value', $original)) {
				$original['value'] = jsonToArray($original['value']);
				
				// Remove old background_image from disk
				if (array_key_exists('background_image', $homeSection->value)) {
					if (
						is_array($original['value'])
						&& isset($original['value']['background_image'])
						&& !empty($original['value']['background_image'])
						&& $homeSection->value['background_image'] != $original['value']['background_image']
						&& $disk->exists($original['value']['background_image'])
					) {
						$disk->delete($original['value']['background_image']);
					}
				}
				
				// Active
				// See the "app/Http/Controllers/Admin/InlineRequestController.php" file for complete operation
				if (array_key_exists('active', $homeSection->value)) {
					$homeSection->active = $homeSection->value['active'];
				}
			}
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param HomeSection $homeSection
	 * @return void
	 */
	public function updated(HomeSection $homeSection)
	{
		//...
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param HomeSection $homeSection
	 * @return void
	 */
	public function saved(HomeSection $homeSection)
	{
		// Removing Entries from the Cache
		$this->clearCache($homeSection);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param HomeSection $homeSection
	 * @return void
	 */
	public function deleted(HomeSection $homeSection)
	{
		// Removing Entries from the Cache
		$this->clearCache($homeSection);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $homeSection
	 * @return void
	 */
	private function clearCache($homeSection)
	{
		try {
			cache()->flush();
		} catch (\Exception $e) {}
	}
}
