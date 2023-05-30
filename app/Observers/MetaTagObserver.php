<?php


namespace App\Observers;

use App\Models\MetaTag;

class MetaTagObserver
{
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param MetaTag $metaTag
	 * @return void
	 */
	public function saved(MetaTag $metaTag)
	{
		// Removing Entries from the Cache
		$this->clearCache($metaTag);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param MetaTag $metaTag
	 * @return void
	 */
	public function deleted(MetaTag $metaTag)
	{
		// Removing Entries from the Cache
		$this->clearCache($metaTag);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $metaTag
	 * @return void
	 */
	private function clearCache($metaTag)
	{
		try {
			cache()->flush();
		} catch (\Exception $e) {}
	}
}
