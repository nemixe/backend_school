<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'employee'], function () use ($router) {
        $router->post('/auth', 'Admin\AuthController@login');
        $router->post('/logout', 'Admin\AuthController@logout');
        $router->get('/profile', 'Admin\EmployeeController@profile');
        // $router->post('/register', 'AuthController@register');
        // $router->post('/login', 'AuthController@login');
        // $router->get('/{id}', 'Admin\EmployeeController@singleUser');
        // $router->get('/', 'Admin\EmployeeController@allUsers');
        // $router->post('/register', 'AuthController@registerStudent');
    });

    $router->group(['prefix' => 'student'], function () use ($router) {
        $router->post('/auth', 'Frontend\AuthController@login');
        $router->get('/refresh', 'Frontend\AuthController@refresh');
        $router->group(['middleware' => 'auth:students'], function() use ($router) {
            $router->post('/logout', 'Frontend\AuthController@logout');
            $router->get('/profile', 'Frontend\StudentController@profile');
        });
        // $router->get('/{id}', 'Frontend\StudentController@singleUser');
    });
    // $router->get('/students', 'Frontend\StudentController@allUsers');

    $router->group(['prefix' => 'teachers'], function () use ($router) {
        $router->post('/register', 'TeacherController@register');
    });
});
