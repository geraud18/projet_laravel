<?php


namespace App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\Create;

trait ClearTmpInputTrait
{
	/**
	 * Clear Temporary Inputs & Files
	 */
	public function clearTemporaryInput()
	{
		if (session()->has('postInput')) {
			session()->forget('postInput');
		}
		
		if (session()->has('picturesInput')) {
			$picturesInput = (array)session()->get('picturesInput');
			if (!empty($picturesInput)) {
				try {
					foreach ($picturesInput as $key => $filePath) {
						$this->removePictureWithItsThumbs($filePath);
					}
				} catch (\Throwable $e) {
					if (!empty($e->getMessage())) {
						flash($e->getMessage())->error();
					}
				}
				session()->forget('picturesInput');
			}
		}
		
		if (session()->has('paymentInput')) {
			session()->forget('paymentInput');
		}
		
		if (session()->has('uid')) {
			session()->forget('uid');
		}
	}
}
