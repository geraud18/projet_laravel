<?php


namespace App\Http\Controllers\Web\Traits;

use App\Helpers\Arr;
use App\Helpers\Files\Storage\StorageDisk;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

trait CommonTrait
{
	public $disk;
	
	/**
	 * Set the storage disk
	 */
	private function setStorageDisk()
	{
		// Get the storage disk
		$this->disk = StorageDisk::getDisk();
		view()->share('disk', $this->disk);
	}
	
	/**
	 * Check & Change the App Key (If needed, for security reasons)
	 */
	private function checkAndGenerateAppKey()
	{
		try {
			if (DotenvEditor::keyExists('APP_KEY')) {
				if (DotenvEditor::getValue('APP_KEY') == 'SomeRandomStringWith32Characters') {
					// Generating a new App Key, remove (or clear) all the sessions and cookies
					Artisan::call('key:generate', ['--force' => true]);
				}
			}
		} catch (\Throwable $e) {}
	}
	
	/**
	 * Load all the installed plugins
	 */
	private function loadPlugins()
	{
		$plugins = plugin_installed_list();
		$plugins = collect($plugins)->map(function ($item, $key) {
			if (is_object($item)) {
				$item = Arr::fromObject($item);
			}
			if (isset($item['item_id']) && !empty($item['item_id'])) {
				$item['installed'] = plugin_check_purchase_code($item);
			}
			
			return $item;
		})->toArray();
		
		config()->set('plugins', $plugins);
		config()->set('plugins.installed', collect($plugins)->whereStrict('installed', true)->toArray());
	}
}
