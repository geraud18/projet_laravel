<?php


namespace App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits;

use Illuminate\Http\Request;

trait WizardTrait
{
	/**
	 * Get Wizard Menu
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param null $post
	 */
	public function shareWizardMenu(Request $request, $post = null)
	{
		$isNewEntry = isPostCreationRequest();
		
		if ($isNewEntry) {
			$menu = $this->getCreateFormMenu($request, $post);
		} else {
			$menu = $this->getEditFormMenu($request, $post);
		}
		
		view()->share('wizardMenu', $menu);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param null $post
	 * @return array
	 */
	private function getCreateFormMenu(Request $request, $post = null)
	{
		$menu = [];
		
		$uriPath = request()->segment(3);
		
		// Listing's Details
		$condition = true;
		$isCompleted = ($request->session()->has('postInput') && !empty($request->session()->get('postInput')));
		$url = url('posts/create');
		$class = ($uriPath == '')
			? 'active'
			: ((in_array($uriPath, ['photos', 'packages', 'finish']) || $isCompleted) ? '' : 'disabled');
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('listing_details'),
		];
		
		// Pictures
		$condition = true;
		$isCompleted = ($request->session()->has('picturesInput') && !empty($request->session()->get('picturesInput')));
		$url = $isCompleted ? url('posts/create/photos') : null;
		$class = ($uriPath == 'photos')
			? 'active'
			: ((in_array($uriPath, ['photos', 'packages', 'finish']) || $isCompleted) ? '' : 'disabled');
		$menu[] = [
			'condition' => $condition,
			'class'     => 'picturesBloc ' . $class,
			'url'       => $url,
			'name'      => t('Photos'),
		];
		
		// Payment
		$condition = (
			isset($this->countPackages, $this->countPaymentMethods)
			&& $this->countPackages > 0
			&& $this->countPaymentMethods > 0
		);
		$isCompleted = ($request->session()->has('paymentInput') && !empty($request->session()->get('paymentInput')));
		$url = $isCompleted ? url('posts/create/payment') : null;
		$class = ($uriPath == 'payment')
			? 'active'
			: ((in_array($uriPath, ['finish']) || $isCompleted) ? '' : 'disabled');
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('Payment'),
		];
		
		// Activation
		$condition = ($uriPath == 'activation');
		$url = null;
		$class = ($uriPath == 'activation') ? 'active' : 'disabled';
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('Activation'),
		];
		
		// Finish
		$condition = ($uriPath != 'activation');
		$url = null;
		$class = ($uriPath == 'finish') ? 'active' : 'disabled';
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('Finish'),
		];
		
		return $menu;
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param null $post
	 * @return array
	 */
	private function getEditFormMenu(Request $request, $post = null)
	{
		$menu = [];
		
		$uriPath = request()->segment(3);
		
		// Listing's Details
		$condition = (!in_array($uriPath, ['finish']));
		$isCompleted = !empty($post);
		$url = $isCompleted ? url('posts/' . data_get($post, 'id') . '/edit') : url('posts/create');
		$class = (in_array($uriPath, [null, 'edit'])) ? 'active' : '';
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('listing_details'),
		];
		
		// Pictures
		$condition = (!in_array($uriPath, ['finish']));
		$isCompleted = !empty($post);
		$url = $isCompleted ? url('posts/' . data_get($post, 'id') . '/photos') : null;
		$class = ($uriPath == 'photos') ? 'active' : '';
		$menu[] = [
			'condition' => $condition,
			'class'     => 'picturesBloc ' . $class,
			'url'       => $url,
			'name'      => t('Photos'),
		];
		
		// Payment
		$condition = (
			(!in_array($uriPath, ['finish']))
			&& isset($this->countPackages, $this->countPaymentMethods)
			&& $this->countPackages > 0
			&& $this->countPaymentMethods > 0
		);
		$isCompleted = !empty($post);
		$url = $isCompleted ? url('posts/' . data_get($post, 'id') . '/payment') : null;
		$class = ($uriPath == 'payment') ? 'active' : '';
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('Payment'),
		];
		
		// Finish
		$condition = true;
		$url = null;
		$class = ($uriPath == 'finish') ? 'active' : 'disabled';
		$menu[] = [
			'condition' => $condition,
			'class'     => $class,
			'url'       => $url,
			'name'      => t('Finish'),
		];
		
		return $menu;
	}
}
