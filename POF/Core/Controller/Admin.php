<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Helpers\Helper;
use Core\Model\Stock;
use Core\Model\Transaction;
use Core\Model\User;

class Admin extends Controller
{
    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }

    function __construct()
    {
        $this->auth();
        if (!isset($_SESSION['user'])) {
            Helper::redirect('./');
        }
    }

    /**
     * GET ALL ITEMS AND TRANSACTIONS AND USERS
     * 
     * @return void
     */
    public function index()
    {
        $this->permissions(['user:read']);
        $this->view = "dashboard";
        $user = new User;
        $transaction = new Transaction;
        $stock = new Stock;

        $total_sales = 0;
        $get_total_sales = $transaction->get_all();
        foreach ($get_total_sales as $total) {
            $total_sales += $total->total;
        }

        $quantity = 0;
        $get_quantity = $stock->get_all();
        foreach ($get_quantity as $total) {
            $quantity += $total->quantity;
        }

        $top_five_expensive = array();
        $stmt = $stock->connection->prepare("SELECT * FROM stocks ORDER BY price DESC LIMIT 5");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $top_five_expensive[] = $row;
            }
        }

        $this->data['user_count'] = count($user->get_all());
        $this->data['total_sales'] = $total_sales;
        $this->data['total_transactions'] = count($transaction->get_all());
        $this->data['quantity'] = $quantity;
        $this->data['top_five_expensive'] = $top_five_expensive;
    }
}
