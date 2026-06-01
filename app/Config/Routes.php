<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Public Routes (No Filter) ───────────────────────────────────────────────
$routes->get('/',             'Auth::index');
$routes->get('login',         'Auth::index');
$routes->post('login',        'Auth::index');
$routes->get('logout',        'Auth::logout');
$routes->get('register',      'Auth::register');
$routes->post('register',     'Auth::registration');
$routes->get('unauthorized',  'Auth::unauthorized'); // STEP 6: Uncontrolled Route

// ── Student Routes (filter: ['auth', 'student']) ────────────────────────────
$routes->group('', ['filter' => ['auth', 'student']], function ($routes) {
    $routes->get('student/dashboard', 'StudentController::dashboard');
});

// ── Authenticated (any role) routes ────────────────────────────────────────
$routes->group('', ['filter' => ['auth']], function ($routes) {
    $routes->get('profile',           'ProfileController::show');
    $routes->get('profile/edit',      'ProfileController::edit');
    $routes->post('profile/update',   'ProfileController::update');
});

// Allow any authenticated user (admins included) to access student edit/update/delete routes
$routes->get('student/edit/(:num)',     'Student::edit/$1', ['filter' => 'auth']);
$routes->post('student/update/(:num)',  'Student::update/$1', ['filter' => 'auth']);
$routes->post('student/delete/(:num)',  'Student::delete/$1', ['filter' => 'auth']);

// ── Teacher Routes (filter: ['auth', 'teacher']) ────────────────────────────
$routes->group('', ['filter' => ['auth', 'teacher']], function ($routes) {
    $routes->get('dashboard',                 'Home::index');
    $routes->get('students',                  'StudentManagementController::index');
    $routes->get('students/show/(:num)',      'StudentManagementController::show/$1');
    $routes->post('student/store',            'Student::store');
});

// Allow any authenticated teacher/admin/coordinator to edit student records.
$routes->get('students/edit/(:num)',      'StudentManagementController::edit/$1', ['filter' => 'auth']);
$routes->post('students/update/(:num)',   'StudentManagementController::update/$1', ['filter' => 'auth']);

// ── Admin Routes (filter: ['auth', 'admin']) ────────────────────────────────
$routes->group('admin', ['filter' => ['auth', 'admin']], function ($routes) {
    // Role CRUD
    $routes->get('roles',                     'Admin\RoleController::index');
    $routes->get('roles/create',              'Admin\RoleController::create');
    $routes->post('roles/store',              'Admin\RoleController::store');
    $routes->get('roles/edit/(:num)',         'Admin\RoleController::edit/$1');
    $routes->post('roles/update/(:num)',      'Admin\RoleController::update/$1');
    $routes->get('roles/delete/(:num)',       'Admin\RoleController::delete/$1');

    // User Role Assignment
    $routes->get('users',                     'Admin\UserAdminController::index');
    $routes->post('users/assign-role/(:num)', 'Admin\UserAdminController::assignRole/$1');
    $routes->get('users/edit/(:num)',        'Admin\UserAdminController::edit/$1');
    $routes->post('users/update/(:num)',     'Admin\UserAdminController::update/$1');

    // Allow admins to edit student records as well
    $routes->get('student/edit/(:num)',      'Student::edit/$1');
    $routes->post('student/update/(:num)',   'Student::update/$1');
    $routes->post('student/delete/(:num)',   'Student::delete/$1');
});

// ── API v1 Routes ────────────────────────────────────────────────────────────
$routes->post('api/v1/auth/token', 'Api\AuthController::issueToken');

$routes->group('api/v1', ['filter' => 'api_auth'], function ($routes) {
    $routes->delete('auth/token',      'Api\AuthController::revokeToken');
    $routes->get('profile',            'Api\StudentsController::profile');
    $routes->get('students',           'Api\StudentsController::index');
    $routes->get('students/(:num)',    'Api\StudentsController::show/$1');
});
