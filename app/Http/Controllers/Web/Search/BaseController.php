<?php


namespace App\Http\Controllers\Web\Search;

use App\Http\Controllers\Web\FrontController;
use App\Http\Controllers\Web\Search\Traits\MetaTagTrait;
use App\Http\Controllers\Web\Search\Traits\TitleTrait;
use Illuminate\Http\Request;

class BaseController extends FrontController
{
	use MetaTagTrait, TitleTrait;
	
	public $request;
	
	/**
	 * SearchController constructor.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct();
		
		$this->middleware(function ($request, $next) {
			return $next($request);
		});
		
		$this->request = $request;
	}
	
	/**
	 * @param array|null $sidebar
	 * @return void
	 */
	protected function bindSidebarVariables(?array $sidebar = []): void
	{
		if (!empty($sidebar)) {
			foreach ($sidebar as $key => $value) {
				view()->share($key, $value);
			}
		}
	}
	
	/**
	 * Set the Open Graph info
	 *
	 * @param $og
	 * @param $title
	 * @param $description
	 * @param array|null $apiExtra
	 * @return void
	 */
	protected function setOgInfo($og, $title, $description, ?array $apiExtra = null): void
	{
		$og->title($title)->description($description)->type('website');
		
		if (!is_array($apiExtra) || (int)data_get($apiExtra, 'count.0') > 0) {
			if ($og->has('image')) {
				$og->forget('image')->forget('image:width')->forget('image:height');
			}
		}
		
		view()->share('og', $og);
	}
}
