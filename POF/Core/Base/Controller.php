<?php

namespace Core\Base;

use Core\Helpers\Helper;
use Core\Model\User;

abstract class Controller
{
    abstract public function render();


    protected $view = null;
    protected $data = array();


    /**
     * SEND VIEW HTML TEMPLATE AND DATA
     * 
     * @return void
     */
    protected  function view()
    {
        new View($this->view, $this->data);
    }


    /**
     * IF USER DOES'T EXISTING 
     * 
     * @return void
     */
    protected function auth()
    {
        if (!isset($_SESSION['user'])) {
            Helper::redirect('/login');
        }
    }

    /**
     * check if the user has the assigned permissions
     * 
     * @param array $permissions_set
     * @return void
     */
    protected function permissions(array $permissions_set)
    {
        $this->auth();
        $user = new User;
        $assigned_permissions = $user->get_permission();
        foreach ($permissions_set as $permission) {
            if (!in_array($permission, $assigned_permissions)) {
                if ($_SESSION['user']['role'] == 'Seller') {
                    Helper::redirect('/selling');
                } elseif ($_SESSION['user']['role'] == 'Accountant') {
                    Helper::redirect('/transactions');
                } elseif ($_SESSION['user']['role'] == 'Procurement') {
                    Helper::redirect('/stocks');
                }
            }
        }
    }
}
