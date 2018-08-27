<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
define('DS',DIRECTORY_SEPARATOR);

global $project_path;
$project_path = env('LARAVAL_ROOT');

View::addLocation($project_path . DS . 'templates');

Route::any('{path}', function ($path = "") {
  global $project_path;
  $path_info = pathinfo($path);
  $view_path = preg_replace("/\\.blade\\.php$/", "", $path);

  $check_view_path = $project_path . DS . 'templates'. DS . $view_path . '.blade.php';
  if (!file_exists($check_view_path)) {
    return abort(404);
  }

  $json_path = $project_path . DS . 'data'. DS . $view_path . '.json';
  if (file_exists($json_path)) {
    $json_string = file_get_contents($json_path);  
    $data = json_decode($json_string, true); 
  } else {
     $data = [];
  }

  return view($view_path, $data);
})->where('path', '.*\.blade.php');


