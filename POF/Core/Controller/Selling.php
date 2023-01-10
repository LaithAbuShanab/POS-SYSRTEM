<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Model\Stock;
use Core\Model\Transaction;

class Selling extends Controller
{

    /**
     * CHECK IF USER EXISTING AND SHOW THE HTML FOR SELLER
     * 
     * @return void
     */
    function __construct()
    {
        $this->auth();
        $this->permissions(['selling:read']);
        $this->view = 'sellers.index';
    }

    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }
}
