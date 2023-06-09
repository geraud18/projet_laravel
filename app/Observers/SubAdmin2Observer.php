<?php


namespace App\Observers;

use App\Models\City;
use App\Models\SubAdmin2;

class SubAdmin2Observer
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param SubAdmin2 $admin
	 * @return void
	 */
	public function deleting(SubAdmin2 $admin)
	{
		// Delete all the Admin's Cities
		$cities = City::countryOf($admin->country_code)->where('subadmin2_code', $admin->code);
		if ($cities->count() > 0) {
			foreach ($cities->cursor() as $city) {
				$city->delete();
			}
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param SubAdmin2 $admin
	 * @return void
	 */
	public function saved(SubAdmin2 $admin)
	{
		// Removing Entries from the Cache
		$this->clearCache($admin);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param SubAdmin2 $admin
	 * @return void
	 */
	public function deleted(SubAdmin2 $admin)
	{
		// Removing Entries from the Cache
		$this->clearCache($admin);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $admin
	 */
	private function clearCache($admin)
	{
		try {
			cache()->flush();
		} catch (\Exception $e) {
		}
	}
}
