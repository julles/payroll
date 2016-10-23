<?php namespace Admin\Helper;

use App\Models\MasterDepartment;
use App\Models\MasterEmployee;
use App\Models\MasterPosition;
use App\User;

class SqlRepo
{
	public function comboDepartments()
	{
		$model = MasterDepartment::lists('department','id')
			->toArray();

		return $model;
	}

	public function comboPositions($department_id = "")
	{
		$model = new MasterPosition;

		if(!empty($department_id))
		{
			$model = $model->whereDepartmentId($department_id);
		}

		$model = $model->lists('position','id')
			->toArray();

		return $model;
	}

	public function comboUserFiltered($id = "")
	{
		$model = new User;

		$notIn = MasterEmployee::select('user_id')
		->get();

		if(!empty($id))
		{
			$notIn = $notIn->where('user_id','!=',$id);

		}

		$notIn = array_flatten($notIn->toArray());
		$model = $model->whereNotIn('id',$notIn)
		->get()
		->lists('name_email','id')
		->toArray();

		return $model;

	}

}