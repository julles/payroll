<?php
/**
 * Admin Routes here
 */

Route::get('/' , function(){
	return redirect('login');
});

Route::group(['middlewareGroups'=>['web']] , function(){
	Route::controller('login','Admin\LoginController');
});


Route::controller('absent','AbsentController');

Route::group(['middleware'=>['auth','admin'] ,'prefix'=> \Admin::backendUrl()] , function(){
	
	\App::setLocale('id');
	
	if(\Schema::hasTable('menus'))
	{
		foreach(\Site::parentIsNotNull() as $row)
		{
			if(Site::controllerExists($row) == true)
			{
				Route::controller($row->slug,$row->controller);
			}else{
				Route::get($row->slug.'/index' , function(){
					throw new \Exception("Controller tidak ditemukan mas :) , cek method controllerExists() di class Site.", 1);
				});
			}
		}

		Route::get('my-profile/index','Admin\MyProfileController@getMyProfile');
	}
});