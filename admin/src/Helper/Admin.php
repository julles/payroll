<?php namespace Admin\Helper;

use Html;
use App\Models\Menu;
use DB;
use App\Models\Right;
class Admin
{

	public function noReply()
	{
		return config('admin.noReply');
	}

	/**
	 * Mengambil variable defaultPage di file admin.php
	 * @return [string]
	 */
	public function defaultPage()
	{
		return config('admin.defaultPage');
	}


	/**
	 * Mengambil variable backendUrl di file admin.php
	 * @return [string]
	 */
	public function backendUrl()
	{
		return config('admin.backendUrl');
	}

	/**
	 * Mengambil variable projectName di file admin.php
	 * @return [string]
	 */
	public function projectName()
	{
		return config('admin.projectName');
	}

	/**
	 * asset path di tambahin adminlte, jadi bisa dinamis kalo path css adminlte berubah
	 * @return [string]
	 */
	public function assetAdmin($plus="")
	{
		return asset('adminlte');
	}

	/**
	 * mengambil data prefix di route group admin
	 * @return [string] 
	 */
	public function getPrefix()
	{
		return request()->route()->getPrefix();
	}

	/**
	 * mengambil method action controller
	 * @return [string] ex : getIndex(),getUpdate()
	 */
	public function getAction()
	{
		$currentRoute =  request()->route()->getActionName();
		$explode = explode('@',$currentRoute);
		return $explode[1];
	}

	/**
	 * mengambil action di url 
	 * @return [string] ex : index,update,delete
	 */
	public function rawAction()
	{
		$url =  request()->url();	
		$arr = explode("/",$url);
		$count = count($arr);
		$end = end($arr);
		$min = is_numeric($end) ? 2 : 1;
		return $arr[$count-$min];	
	}

	/**
	 * mengambil menu di url 
	 * @return [string] ex : role,user,ect.
	 */
	public function rawMenu()
	{
		$url =  request()->url();	
		$arr = explode("/",$url);
		$count = count($arr);
		$end = end($arr);
		$min = is_numeric($end) ? 3 : 2;
		return $arr[$count-$min];
	}

	/**
	 * Mereturn data satu record dari table menu by parameter slug
	 * kalo slug kosong maka parameter pembanding yang diambil method rawMenu()
	 * @param  string $slug [paramter pembanding slug]
	 * @return [string]
	 */
	public function getMenu($slug = "")
	{
		$model = new Menu;

		if(!empty($slug))
		{
			$model = $model->whereSlug($slug);
		}else{
			$model = $model->whereSlug($this->rawMenu());
		}
		
		return $model->first();
	}

	public function getParentMenu($slug = "")
	{
		$menu = $this->getMenu($slug);

		return $menu->parent;
	}

	public function labelMenu($slug="")
	{
		return $this->getMenu($slug)->title;
	}

	public function labelParentMenu($slug="")
	{
		$parent = $this->getParentMenu($slug);

		if(!empty($parent))
		{
			$result = $parent->title;
		}else{
			$result = "";
		}
		return $result;
	}

	public function labelAction()
	{
		$action = $this->rawAction();
	
		$result = ucwords($action);
	
		return $result;
	}

	public function urlBackend($menu)
	{
		$prefix = $this->backendUrl();

		if($prefix == '/')
		{
			$prefix = "";
		}

		return url($prefix.'/'.$menu);
	}

	public function  urlBackendAction($action)
	{
		$prefix = $this->getPrefix();
		if($prefix == '/')
		{
			$menu = request()->segment(1);
			$result = $menu.'/'.$action;
		}else{
			$menu = request()->segment(2);
			$result = $prefix.'/'.$menu.'/'.$action;
		}

		return url($result);
	}

	public function cekMenuAction($code)
	{
		$menu = $this->getMenu();

		$action = $menu->actions()
			->whereCode($code)
			->first();

		return $action;
	}

	public function cekRight($actionCode = "",$menu="")
	{
		$result = 'false';
		$role = user()->role;
		$actionCode = !empty($actionCode) ? $actionCode : $actionCode = $this->rawAction();
		
			if(!empty($actionCode))
			{
				$action = $this->dbAction($actionCode);

				if(empty($action->id))
				{
					$result = 'true';
				}else{
					$menu = empty($menu) ? $this->getMenu() : $menu;
					$cek = $menu->menuAction()
					->where('action_id',$action->id)
					->first();
					
					if(!empty($cek->id))
					{
						$right = Right::whereMenuActionId($cek->id)
							->whereRoleId(user()->role->id)
							->first();
						
						if(!empty($right->id))
						{
							$result = "true";
						}else{
							$result = 'false';
						}
					}else{
						$result = 'false';
					}
				}
			}
		return $result;	
	}

	

	public function linkCreate()
	{
		$create = $this->cekRight('create');
		if($create == 'true')
			return Html::link($this->urlBackendAction('create'),'Create',[
				'class'=>'btn btn-primary'
			]);
	}

	public function linkApprove($plus="")
	{
		$approve = $this->cekRight('approve');
		if($approve == 'true')
			return Html::link($this->urlBackendAction('approve/'.$plus),'Approve',[
				'class'=>'btn btn-success',
			]);
	}

	public function linkUpdate($plus="")
	{
		$update = $this->cekRight('update');
		
		if($update == 'true')	
			return Html::link($this->urlBackendAction('update/'.$plus),'Update',[
				'class'=>'btn btn-success btn-sm'
			]);
	}

	public function linkView($plus="")
	{
		$view = $this->cekRight('view');
		
		if($view == 'true')	
			return Html::link($this->urlBackendAction('view/'.$plus),'View',[
				'class'=>'btn btn-info btn-sm'
			]);
	}

	public function linkDelete($plus="")
	{
		$delete = $this->cekRight('delete');
		
		if($delete == 'true')	
		
			return Html::link($this->urlBackendAction('delete/'.$plus),'Delete',[
				'class'=>'btn btn-danger btn-sm',
				'onclick'=>'return confirm("Are you sure want to delete this item ?")'
			]);
	}

	public function linkPublish()
	{
		
	}

	public function linkActions($plus="")
	{
		$actions = $this->inject('Action')
			->select('code')
			->whereNotIn('code',['create','index','approve'])
			->get();

		$links = "";

		foreach($actions as $action)
		{
			$upper = ucwords($action->code);
			$method = "link$upper";
			$links .= $this->{$method}($plus).' ';
		}

		return $links;
	}

	public function randomImage()
	{
		return md5(date("YmdHis"));
	}

	public function publicContents($file)
	{
		return public_path('contents/'.$file);
	}

	public function assetContents($file)
	{
		return asset('contents/'.$file);
	}

	public function getId()
	{
		$url = request()->url();
		$ex = explode("/",$url);
		return end($ex);
	}

	public function inject($model)
	{
		$model =  "App\Models\\$model";
	
		return new $model;
	}

	public function urlDefaultPage()
	{
		return $this->urlBackend($this->defaultPage().'/index');
	}

	public function dbAction($code = "")
	{
		$model = $this->inject('Action');

		$model = $model->whereCode($code)->first();

		return $model;
	}

	public function addMenu($params=[] , $actions=[])
	{
		DB::beginTransaction();
	
		try {
				$cek = $this->getMenu($params['slug']);

				if(empty($cek->slug))
				{
					if($params['parent_id'] != null)
					{
						$cekParent = $this->getMenu($params['parent_id']);

						if(!empty($cekParent->slug))
						{
							$params['parent_id'] = $cekParent->id;
						}
					}

					$model = Menu::create($params);
					
					$modelMenuAction = $this->inject('MenuAction');
					
					foreach($actions as $action)
					{
						$modelAction = $this->dbAction($action);
						if(!empty($modelAction->id))
						{
							$save = $modelMenuAction->create([
								'menu_id'=>$model->id,
								'action_id'=>$modelAction->id,
							]);

							Right::create([
								'role_id'=>1,
								'menu_action_id'=>$save->id,
							]);
						}
					}		
				}
				DB::commit();		
		} catch (Exception $e) {
				DB::rollback();
		}			
	}

	public function updateMenu($params=[] , $actions=[])
	{
		$cek = $this->getMenu($params['slug']);

		$cekParent = $this->getMenu($params['parent_id']);

		if(!empty($cekParent->slug))
		{
			$params['parent_id'] = $cekParent->id;
		}

		if(!empty($cek->id))
		{
			$cek->menuAction()->delete();
		}

		$model = $this->getMenu($params['slug']);
		
		$model->update($params);

		$modelMenuAction = $this->inject('MenuAction');
		
		foreach($actions as $action)
		{
			$modelAction = $this->dbAction($action);
			if(!empty($modelAction->id))
			{
				//$modelMenuAction->whereMenuId($model->id)->delete();
				$save = $modelMenuAction->create([
					'menu_id'=>$model->id,
					'action_id'=>$modelAction->id,
				]);
				Right::create([
					'role_id'=>1,
					'menu_action_id'=>$save->id,
				]);
			}
		}
	}

	public function deleteMenu($slug)
	{
		$this->getMenu($slug)->delete();
	}

	function formatMoney($int)
	{
		$numberFormat = number_format($int,2);

		$replace = str_replace(",", ".", $numberFormat);

		$substring = substr($replace , 0 , -3);

		return $substring;
	}

	public function toInteger($str)
	{
		return $replace = str_replace(".", "", $str);
	}

	public function toString($string = "")
	{
		$replace = str_replace("_"," ",$string);

		return ucwords($replace);
	}

	public function toUnderscore($string)
	{
		$replace = str_replace(" ","_",$string);

		return strtolower($replace);
	}


}