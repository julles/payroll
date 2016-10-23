<?php
Route::get('/',function(){
	echo "WELCOME TO MYBACKEND";
});
Route::controller('api','ApiController');
include __DIR__.'/admin_routes.php';

