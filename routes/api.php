<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


#declare route here

#PROJECT 
Route::post('/project/create','CreateProjectController@create');
Route::get('/project/view','CreateProjectController@view');
Route::post('/project/update','CreateProjectController@update');


#BUSINESS PLAN
Route::post('/business_plan/create','BusinessPlanController@create');
Route::post('/business_plan/view','BusinessPlanController@view');
Route::post('/business_plan/update','BusinessPlanController@update');
Route::post('/business_plan/delete','BusinessPlanController@delete');


#TO DO
Route::post('/to_do/master_create','ToDoController@master_create');
Route::post('/to_do/master_archieve','ToDoController@master_archieve');
Route::post('/to_do/master_view','ToDoController@master_view');
Route::post('/to_do/ui_create','ToDoController@ui_create');
Route::post('/to_do/ui_view','ToDoController@ui_view');
Route::post('/to_do/master_details','ToDoController@master_details');
Route::post('/to_do/child_create','ToDoController@child_create');
Route::post('/to_do/child_view','ToDoController@child_view');
Route::post('/to_do/child_archieve','ToDoController@child_archieve');


#Articles
Route::post('/article/create','ArticleController@create');
Route::post('/article/view','ArticleController@view');
Route::post('/article/details_view','ArticleController@details_view');
Route::post('/article/archieve','ArticleController@archieve');
Route::post('/article/category_count','ArticleController@category_count');
Route::post('/article/category_view','ArticleController@category_view');



#Documentation
Route::post('/document/create','DocumentationController@create');
Route::post('/document/archieve','DocumentationController@archieve');
Route::post('/document/view','DocumentationController@view');



#Calendar
Route::post('/calendar/create','CalendarController@create');
Route::post('/calendar/update','CalendarController@update');
Route::post('/calendar/archieve','CalendarController@archieve');
Route::post('/calendar/view','CalendarController@view');
Route::post('/calendar/all_calendar','CalendarController@all_calendar');
Route::post('/calendar/data_calendar','CalendarController@data_calendar');    


# Register 
Route::post('/register/create','RegisterController@create');
Route::post('/register/forgot_password','RegisterController@forgot_password');


# Login 
Route::post('/login/create','LoginController@create');



# Team Members 
Route::post('/teammembers/create','TeammemberController@create');
Route::post('/teammembers/view','TeammemberController@view');
Route::post('/teammembers/delete','TeammemberController@delete');
