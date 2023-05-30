<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Panel\PanelController;
use App\Http\Requests\Admin\PostTypeRequest as StoreRequest;
use App\Http\Requests\Admin\PostTypeRequest as UpdateRequest;

class PostTypeController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\PostType');
		$this->xPanel->setRoute(admin_uri('p_types'));
		$this->xPanel->setEntityNameStrings(trans('admin.listing type'), trans('admin.listing types'));
		$this->xPanel->denyAccess(['create', 'delete']);
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => "id",
			'label' => "ID",
		]);
		$this->xPanel->addColumn([
			'name'  => "name",
			'label' => trans('admin.Name'),
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'       => "name",
			'label'      => trans('admin.Name'),
			'type'       => "text",
			'attributes' => [
				'placeholder' => trans('admin.Name'),
			],
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
