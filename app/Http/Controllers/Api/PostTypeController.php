<?php


namespace App\Http\Controllers\Api;

use App\Http\Resources\EntityCollection;
use App\Http\Resources\PostTypeResource;
use App\Models\PostType;

/**
 * @group Listings
 */
class PostTypeController extends BaseController
{
	/**
	 * List listing types
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{
		$postTypes = PostType::query()->get();
		
		$resourceCollection = new EntityCollection(class_basename($this), $postTypes);
		
		$message = ($postTypes->count() <= 0) ? t('no_post_types_found') : null;
		
		return $this->respondWithCollection($resourceCollection, $message);
	}
	
	/**
	 * Get listing type
	 *
	 * @urlParam id int required The listing type's ID. Example: 1
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show($id): \Illuminate\Http\JsonResponse
	{
		$postType = PostType::query()->where('id', $id);
		
		$postType = $postType->first();
		
		abort_if(empty($postType), 404, t('post_type_not_found'));
		
		$resource = new PostTypeResource($postType);
		
		return $this->respondWithResource($resource);
	}
}
