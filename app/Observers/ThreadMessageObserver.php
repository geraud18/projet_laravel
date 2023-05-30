<?php


namespace App\Observers;

use App\Helpers\Files\Storage\StorageDisk;
use App\Models\ThreadMessage;

class ThreadMessageObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param ThreadMessage $message
	 * @return void
	 */
	public function deleting(ThreadMessage $message)
	{
		// Storage Disk Init.
		$disk = StorageDisk::getDisk();
		
		// Delete the message's file
		if (!empty($message->filename)) {
			if ($disk->exists($message->filename)) {
				$disk->delete($message->filename);
			}
		}
	}
}
