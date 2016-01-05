<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::filter('nocache', function($route, $request, $response){
  $response->header('Expires', 'Tue, 1 Jan 1980 00:00:00 GMT');
  $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  $response->header('Pragma', 'no-cache');
  return $response;
});

Route::pattern('id', '[0-9]+');

Route::get('/', 'HomeController@index');

Route::get('/login', 'HomeController@login');
Route::post('/login', 'HomeController@doLogin');

Route::get('/register', 'HomeController@register');
Route::post('/register', 'HomeController@doRegister');

Route::post('/register/check', 'HomeController@registerCheck');

Route::get('/logout', 'AdminController@logout');

Route::group(array('before' => 'auth', 'after' => 'nocache'), function(){

    Route::get('/admin', 'AdminController@index');

    Route::get('/account', 'AdminController@account');
    Route::post('/account', 'AdminController@updateAccount');

    Route::get('/holidays/new', 'AdminController@newHoliday');
    Route::post('/holidays/create', 'AdminController@createHoliday');

    Route::get('/holidays/{id}', 'AdminController@holiday');
    Route::post('/holidays/{id}', 'AdminController@updateHoliday');

    Route::get('/classes/new', 'AdminController@newClass');
    Route::post('/classes/create', 'AdminController@createClass');

    Route::get('/classes', 'AdminController@classes');
    
    Route::get('/class/{id}', 'AdminController@viewClass');
    Route::post('/class/{id}', 'AdminController@updateClass');

    Route::post('/student/remove', 'AdminController@removeStudent');

    Route::get('/attendance/{id?}', 'AdminController@attendance');
    Route::post('/attendance', 'AdminController@updateAttendance');

    Route::get('/to-drop/{id}', 'AdminController@studentsToDrop');

    Route::get('/dropped/{id}', 'AdminController@droppedStudents');

    Route::post('/drop', 'AdminController@updateStudentStatus');
    Route::post('/claim', 'AdminController@updateStudentStatus');

    Route::get('/absences/{id}', 'AdminController@absences');


    Route::get('/semester', 'AdminController@semesterSettings');
    Route::post('/semester', 'AdminController@updateSemesterSettings');
});

Route::get('/password/forgot', 'RemindersController@getRemind');
Route::post('/password/remind', 'RemindersController@postRemind');

Route::get('/password/reset/{token}', 'RemindersController@getReset');
Route::post('/password/reset', 'RemindersController@postReset');

Route::get('/import', function(){

	$class_id = 2;
	$student_id = '1100723';

	$date = '2015-09-12';

	$id = $class_id . $student_id;

	$drop_absences_count = 1;

	$attendance = new StudentAttendance;
	$attendance->student_id = $student_id;
	$attendance->class_id = $class_id;
	$attendance->date = $date;
	$attendance->type = 'absent';
	$attendance->save();


	$current_absence_count = DB::table('student_classes')
	    ->where('id', '=', $id)
	    ->pluck('current_absence_count');

	$current_absence_count += 1;

	if($current_absence_count == $drop_absences_count){
	    //update status to: to_drop
	    DB::table('student_classes')
	        ->where('id', '=', $id)
	        ->update(array(
	            'status' => 'to_drop'
	        ));
	}

	//increment current_absence_count
	DB::table('student_classes')
	    ->where('id', $id)
	    ->increment('current_absence_count');


	return 'done!';

});