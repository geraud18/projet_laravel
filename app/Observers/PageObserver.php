<?php


namespace App\Observers;

use App\Helpers\Files\Storage\StorageDisk;
use App\Models\Page;

class PageObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function deleting($page)
	{
		// Storage Disk Init.
		$disk = StorageDisk::getDisk();
		
		// Delete the page picture
		if (!empty($page->picture)) {
			if ($disk->exists($page->picture)) {
				$disk->delete($page->picture);
			}
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function saved(Page $page)
	{
		// Removing Entries from the Cache
		$this->clearCache($page);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Page $page
	 * @return void
	 */
	public function deleted(Page $page)
	{
		// Removing Entries from the Cache
		$this->clearCache($page);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $page
	 */
	private function clearCache($page)
	{
		try {
			cache()->flush();
		} catch (\Exception $e) {
		}
	}
}
