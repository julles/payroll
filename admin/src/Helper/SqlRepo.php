<?php namespace Admin\Helper;

use App\Models\MasterDepartment;
use App\Models\MasterPosition;

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

}