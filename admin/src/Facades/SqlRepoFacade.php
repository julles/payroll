<?php namespace Admin\Facades;

use Illuminate\Support\Facades\Facade;

class SqlRepoFacade extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'register-sqlrepo';
	}
}