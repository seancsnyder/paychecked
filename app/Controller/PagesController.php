<?php
    /**
     * Static content controller.
     *
     * This file will render views from views/pages/
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
     * @package       app.Controller
     * @since         CakePHP(tm) v 0.2.9
     * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
     */

    App::uses('AppController', 'Controller');

    /**
     * Static content controller
     *
     * Override this controller by placing a copy in controllers directory of an application
     *
     * @package       app.Controller
     * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
     */
    class PagesController extends AppController
    {
        public $components = array("Session");


        function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('display');
        }


        public function display()
        {
            $path = func_get_args();

            $count = count($path);
            if (!$count) {
                $this->redirect('/');
            }
            $page = $subpage = $title_for_layout = null;

            if (!empty($path[0])) {
                $page = $path[0];
            }
            if (!empty($path[1])) {
                $subpage = $path[1];
            }
            if (!empty($path[$count - 1])) {
                $title_for_layout = Inflector::humanize($path[$count - 1]);
            }

            if (!strcasecmp($title_for_layout,'home')){$title_for_layout = "paychecked";}

            $title_for_layout = strtolower($title_for_layout);

            $this->set(compact('page', 'subpage', 'title_for_layout','logged_in'));
            $this->render(implode('/', $path));
        }
    }
?>