<?php
// all application routing should be define here
Route::init();
Route::get('home', 'content/home');
Route::get('about', 'content/about');
Route::get('services', 'content/services');
Route::get('contact', 'content/contact');
Route::get('login', 'content/login');
Route::get('registration', 'content/registration');
Route::get('menus/add', 'content/add_menu');
Route::get('admin', 'admin/dashboard');
//Route::get('users', 'users/list');
//Route::get('users/add', 'users/add');
//Route::get('users/store', 'users/store');
Route::get('users/add_new', 'insert');
Route::get('menus/store', 'insert');

//Route::getFinal();