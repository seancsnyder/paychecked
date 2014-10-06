<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


    //static page routes
    Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
    Router::connect('/about', array('controller' => 'pages', 'action' => 'display', 'about'));
    Router::connect('/privacy', array('controller' => 'pages', 'action' => 'display', 'privacy'));
    Router::connect('/contact', array('controller' => 'pages', 'action' => 'display', 'contact'));
    Router::connect('/help', array('controller' => 'pages', 'action' => 'display', 'help'));

    //auth/register routes
    Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
    Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
    Router::connect('/forgot-password', array('controller' => 'users', 'action' => 'forgot_password'));
    Router::connect('/sent-password-reset', array('controller' => 'users', 'action' => 'sent_password_reset'));
    Router::connect('/reset-password/:reset_key', array('controller' => 'users', 'action' => 'reset_password'));

    //acount pages
    Router::connect('/account', array('controller' => 'users', 'action' => 'index'));
    Router::connect('/account/email', array('controller' => 'users', 'action' => 'edit_email'));
    Router::connect('/account/password', array('controller' => 'users', 'action' => 'edit_password'));
    Router::connect('/account/delete', array('controller' => 'users', 'action' => 'delete'));

    //dashboard, paycheck lists
    Router::connect('/dashboard', array('controller' => 'paychecks', 'action' => 'index'));
    Router::connect('/dashboard/past', array('controller' => 'paychecks', 'action' => 'index_past'));

    //paycheck routes
    Router::connect('/income/add', array('controller' => 'paychecks', 'action' => 'add'));
    Router::connect('/income/:id/edit', array('controller' => 'paychecks', 'action' => 'edit'));
    Router::connect('/income/:id/delete', array('controller' => 'paychecks', 'action' => 'delete'));
    Router::connect('/income/:id/duplicate', array('controller' => 'paychecks', 'action' => 'duplicate'));

    //paycheck expense routes
    Router::connect('/income/:paycheck_id/expense/:id/edit', array('controller' => 'paycheck_expenses', 'action' => 'edit'));
    Router::connect('/income/:paycheck_id/expense/:id/delete', array('controller' => 'paycheck_expenses', 'action' => 'delete'));
    Router::connect('/income/:paycheck_id/expense/add', array('controller' => 'paycheck_expenses', 'action' => 'add'));


/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
