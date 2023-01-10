<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Helpers\Helper;
use Core\Model\Stock;
use Core\Model\Transaction;

class Transactions extends Controller
{

    function __construct()
    {
        $this->auth();
    }

    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }

    /**
     * GET ALL TRANSACTION FROM DATABASE
     * 
     * @return void
     */
    public function index()
    {
        $this->permissions(['transaction:read']);
        $this->view = 'transaction.index';
        $transaction = new Transaction;

        $stmt = $transaction->connection->prepare("SELECT users.display_name,users.photo,transactions.id,transactions.item_name, transactions.quantity,transactions.total,transactions.created_at,transactions.updated_at, transaction_user.*
        FROM transaction_user
        JOIN transactions ON transaction_user.transaction_id = transactions.id
        JOIN users ON transaction_user.user_id = users.id
        ORDER BY transactions.id");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $transactions_info = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $transactions_info[] = $row;
            }
        }

        $this->data['transaction_info'] = $transactions_info;
        $this->data['transaction_count'] = count($transaction->get_all());
    }

    /**
     * DISPLAY THE HTML FORM FOR TRANSACTION UPDATE
     * 
     * @return void
     */
    public function edit()
    {
        $this->permissions(['transaction:read', 'transaction:update']);
        $this->view = 'transaction.edit';
        $transaction = new Transaction;
        $stock = new Stock;
        $selected_transaction = $transaction->get_by_id($_GET['id']);
        $item_name = $selected_transaction->item_name;

        $stmt = $stock->connection->prepare("SELECT price FROM stocks WHERE name=?");
        $stmt->bind_param('s', $item_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $price = $row;
            }
        }
        $this->data['transaction'] =  $selected_transaction;
        $this->data['item_price'] =  $price;
    }

    /**
     * UPDATE THE TRANSACTION
     * 
     * @return void
     */
    public function update()
    {
        $this->permissions(['transaction:read', 'transaction:update']);
        $transaction = new Transaction;
        $stock = new Stock;

        $item_name = $_POST['item_name'];
        $_POST['item_name'] = \htmlspecialchars($_POST['item_name']);
        $item_id = $_POST['id'];

        unset($_POST['price']);
        

        if (empty($_POST['quantity'])) {
            $_SESSION['error'] = "You Must";
            Helper::redirect("/transactions/edit?id=$item_id");
        } else {
            if ($_POST['quantity'] < 0) {
                $_SESSION['error'] = "A negative value cannot be entered";
                Helper::redirect("/transactions/edit?id=$item_id");
            } else {
                $stmt = $transaction->connection->prepare("SELECT quantity FROM stocks WHERE name=?");
                $stmt->bind_param('s', $item_name);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $item_quantity = 0;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_object()) {
                        $item_quantity = $row;
                    }
                }
                $stmt = $transaction->connection->prepare("SELECT quantity FROM transactions WHERE id=?");
                $stmt->bind_param('i', $item_id);
                $stmt->execute();
                $result1 = $stmt->get_result();
                $stmt->close();
                $transaction_quantity = 0;
                if ($result1->num_rows > 0) {
                    while ($row = $result1->fetch_object()) {
                        $transaction_quantity = $row;
                    }
                }

                $final_quantity = $item_quantity->quantity + $transaction_quantity->quantity - $_POST["quantity"];
                $transaction->update($_POST);

                $stmt = $stock->connection->prepare("UPDATE stocks SET quantity=$final_quantity WHERE name=?");
                $stmt->bind_param('s', $item_name);
                $stmt->execute();
                $stmt->close();
                $_SESSION['alert_update'] = "Transaction Updated Success";
                Helper::redirect('/transactions');
            }
        }
    }

    /**
     * DELETE THE TRANSACTION
     * 
     * @return void
     */
    public function delete()
    {
        $this->permissions(['transaction:read', 'transaction:delete']);
        $transaction = new Transaction;
        $transaction_id = $_GET['id'];

        $stmt = $transaction->connection->prepare("DELETE FROM transaction_user WHERE transaction_id=?");
        $stmt->bind_param('i', $transaction_id);
        $stmt->execute();
        $stmt->close();

        $transaction->delete($_GET['id']);
        $_SESSION['alert_delete'] = "Transaction Deleted Success";
        Helper::redirect('/transactions');
    }
}
