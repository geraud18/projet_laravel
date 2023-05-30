<?php


namespace App\Observers;

use App\Models\Currency;

class CurrencyObserver
{
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Currency $currency
	 * @return void
	 */
	public function saved(Currency $currency)
	{
		// Removing Entries from the Cache
		$this->clearCache($currency);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Currency $currency
	 * @return void
	 */
	public function deleted(Currency $currency)
	{
		// Removing Entries from the Cache
		$this->clearCache($currency);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $currency
	 * @return void
	 */
	private function clearCache($currency)
	{
		try {
			cache()->flush();
		} catch (\Exception $e) {}
	}
}
