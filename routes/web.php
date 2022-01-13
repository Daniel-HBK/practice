<?php

use Illuminate\Support\Facades\Route;

// Index...
Route::get('/', 'Web\CustomerController@index')->name('customers.index');
Route::post('/filter', 'Web\CustomerController@filter')->name('customers.filter');
Route::get('/reset', 'Web\CustomerController@reset')->name('customers.reset');
