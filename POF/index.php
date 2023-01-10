<?php
session_start();

use Core\Model\User;
use Core\Router;

/**
 * FILTER CLASS NAME TO ACCESS THE PAGES
 * 
 *@param string
 * @return void
 */
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Core') === false)
        return;
    $class_name = str_replace("\\", '/', $class_name);
    $file_path = __DIR__ . "/" . $class_name . ".php";
    require_once $file_path;
});


/**
 * CHECK IF THERE USER_ID COOKIES
 * 
 * @return void
 */
if (isset($_COOKIE['user_id']) && !isset($_SESSION['user'])) {
    $user = new User();
    $logged_in_user = $user->get_by_id($_COOKIE['user_id']);
    $_SESSION['user'] = array(
        'username' => $logged_in_user->username,
        'display_name' => $logged_in_user->display_name,
        'user_id' => $logged_in_user->id,
        'is_admin_view' => true
    );
}


//==============Login Form===================
Router::get('/', "Authentication.login");
Router::get('/logout', "authentication.logout");
Router::post('/authenticate', "authentication.validate");
//==============Login Form===================

//==============Admin dashboard==============
Router::get('/dashboard', "admin.index");
//==============Admin dashboard==============

//==============Seller/API===================
Router::get('/selling', "selling");
Router::get('/sellers', "sellers.index");
Router::get('/transaction/sellers', "sellers.get");
Router::post('/sellers/create', 'sellers.create');
Router::put('/sellers/update', 'sellers.update');
Router::put('/sellers/update/transaction', 'sellers.update_transaction');
Router::delete('/sellers/delete', 'sellers.delete');
//==============Seller/API==================

//==============Stock=======================
Router::get('/stocks', "stocks.index");
Router::get('/stocks/create', "stocks.create");
Router::post('/stocks/store', 'stocks.store');
Router::get('/stocks/edit', 'stocks.edit');
Router::post('/stocks/update', 'stocks.update');
Router::get('/stocks/delete', 'stocks.delete');
//==============Stock=======================

//==============User========================
Router::get('/users', "users.index");
Router::get('/user', "users.single");
Router::get('/user/profile', "users.profile");
Router::get('/users/create', "users.create");
Router::post('/users/store', 'users.store');
Router::get('/users/edit', 'users.edit');
Router::post('/users/update', 'users.update');
Router::get('/users/delete', 'users.delete');
//==============User========================

//==============Transaction=================
Router::get('/transactions', "transactions.index");
Router::get('/transaction', "transactions.single");
Router::get('/transactions/edit', 'transactions.edit');
Router::post('/transactions/update', 'transactions.update');
Router::get('/transactions/delete', 'transactions.delete');
//==============Transaction=================


Router::redirect();
