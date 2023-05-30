<?php


namespace App\Observers;

use App\Models\City;
use App\Models\SubAdmin1;
use App\Models\SubAdmin2;

class SubAdmin1Observer
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param SubAdmin1 $admin
	 * @return void
	 */
	public function deleting(SubAdmin1 $admin)
	{
		// Delete all the Admin's SubAdmin2
		$admin2s = SubAdmin2::countryOf($admin->country_code)->where('subadmin1_code', $admin->code);
		if ($admin2s->count() > 0) {
			foreach ($admin2s->cursor() as $admin2) {
				$admin2->delete();
			}
		}
		
		// Delete all the Admin's Cities
		$cities = City::countryOf($admin->country_code)->where('subadmin1_code', $admin->code);
		if ($cities->count() > 0) {
			foreach ($cities->cursor() as $city) {
				$city->delete();
			}
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param SubAdmin1 $admin
	 * @return void
	 */
	public function saved(SubAdmin1 $admin)
	{
		// Removing Entries from the Cache
		$this->clearCache($admin);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param SubAdmin1 $admin
	 * @return void
	 */
	public function deleted(SubAdmin1 $admin)
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
