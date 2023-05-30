<?php


namespace App\Http\Controllers\Web\Traits;

use Jackiedo\DotenvEditor\Facades\DotenvEditor;

trait EnvFileTrait
{
	/**
	 * Check & Add the missing entries in the /.env file
	 */
	public function checkDotEnvEntries()
	{
		if (!appInstallFilesExist()) {
			return;
		}
		
		$isChanged = false;
		
		// Check the App Config Locale
		if (!DotenvEditor::keyExists('APP_LOCALE')) {
			DotenvEditor::addEmpty();
			DotenvEditor::setKey('APP_LOCALE', config('appLang.abbr'));
			$isChanged = true;
		}
		
		// Check Purchase Code
		if (!DotenvEditor::keyExists('PURCHASE_CODE')) {
			if (!empty(config('settings.app.purchase_code'))) {
				DotenvEditor::addEmpty();
				DotenvEditor::setKey('PURCHASE_CODE', config('settings.app.purchase_code'));
				$isChanged = true;
			}
		}
		
		// MySQL Dump Binary Path
		if (!DotenvEditor::keyExists('DB_DUMP_BINARY_PATH')) {
			DotenvEditor::addEmpty();
			if (DotenvEditor::keyExists('DB_DUMP_COMMAND_PATH')) {
				DotenvEditor::setKey('DB_DUMP_BINARY_PATH', env('DB_DUMP_COMMAND_PATH', ''));
				DotenvEditor::deleteKey('DB_DUMP_COMMAND_PATH');
			} else {
				DotenvEditor::setKey('DB_DUMP_BINARY_PATH', '');
			}
			$isChanged = true;
		}
		
		// API Options
		if (!DotenvEditor::keyExists('APP_API_TOKEN')) {
			DotenvEditor::addEmpty();
			DotenvEditor::setKey('APP_API_TOKEN', base64_encode(createRandomString(32)));
			DotenvEditor::setKey('APP_HTTP_CLIENT', 'none');
			$isChanged = true;
		}
		
		if ($isChanged) {
			DotenvEditor::save();
		}
	}
}
