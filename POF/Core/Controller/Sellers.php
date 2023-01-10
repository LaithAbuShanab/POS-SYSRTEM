<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Model\Stock;
use Core\Model\Transaction;

class Sellers extends Controller
{

    protected $request_body;
    protected $http_code = 200;

    protected $response_schema = array(
        "success" => true,
        "message_code" => "",
        "body" => array()
    );


    function __construct()
    {
        $this->auth();
        $this->request_body = (array) json_decode(file_get_contents("php://input"));
    }

    public function render()
    {
        header("content-type: application/json");
        http_response_code($this->http_code);
        echo json_encode($this->response_schema);
    }


    /**
     * GET THE ALL ITEMS
     * 
     * @return array
     */
    public function index()
    {
        try {
            $stock = new stock;
            $result = $stock->get_all();
            if (!$result) {
                $this->http_code = 404;
                throw new \Exception("Sql_response_error");
            } else {
                $this->response_schema['body'] = $result;
                $this->response_schema['message_code'] = "items_collected_successfully";
            }
        } catch (\Exception $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
        }
    }

    /**
     * GET THE ALL TRANSACTION
     * 
     * @return array
     */
    public function get()
    {
        try {
            $Transaction = new Transaction;
            $item = $Transaction->check_user_today();
            if (empty($item)) {
                $this->http_code = 404;
                throw new \Exception("Sql_response_error");
            }
            $this->response_schema['body'] = $item;
        } catch (\Throwable $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
        }
    }



    /**
     * CREATE AN TRANSACTION
     * 
     * @return array
     */
    public function create()
    {
        try {
            $Transaction = new Transaction;
            if (!isset($this->request_body['item_name'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }

            if (!isset($this->request_body['quantity'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }

            if (!isset($this->request_body['total'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }


            $Transaction->create($this->request_body);
            $Transaction_id = $Transaction->get_by_id($Transaction->connection->insert_id);
            $Transaction_id = $Transaction_id->id;
            $user_id = $_SESSION['user']['user_id'];

            $stmt = $Transaction->connection->prepare("INSERT INTO transaction_user (transaction_id,user_id) VALUES (?,?)");
            $stmt->bind_param('ii', $Transaction_id, $user_id);
            if (!$stmt->execute()) {
                $this->http_code = 500;
                throw new \Exception("transaction_was_not_created");
            }
            $stmt->close();


            $this->response_schema['message_code'] = "transaction_created";
            $this->response_schema['body'][] = $Transaction->get_by_id($Transaction->connection->insert_id);
        } catch (\Exception $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
            $this->http_code = 421;
        }
    }

    /**
     * UPDATE THE ITEM
     * 
     * @return void
     */
    public function update()
    {
        $stock = new Stock;
        try {
            if (!isset($this->request_body['id'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }
            if (!isset($this->request_body['quantity'])) {
                $this->http_code = 422;
                throw new \Exception("quantity_param_not_found");
            }

            $item = $stock->get_by_id($this->request_body['id']);
            if (empty($item)) {
                $this->http_code = 404;
                throw new \Exception("item_not_found");
            }

            $quantity =  $this->request_body['quantity'];
            $stmt = $stock->connection->prepare("UPDATE stocks SET quantity=? WHERE id=?");
            $stmt->bind_param('ii', $quantity, $this->request_body['id']);
            if (!$stmt->execute()) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_created");
            }
            $stmt->close();


            $this->response_schema['message_code'] = "item_updated";
        } catch (\Exception $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
        }
    }

    /**
     * UPDATE THE ITEM QUANTITY ANR THE TRANSACTION QUANTITY
     * 
     * @return void
     */
    public function update_transaction()
    {
        $transaction = new Transaction;
        $stock = new Stock;

        try {
            if (!isset($this->request_body['id'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }
            if (!isset($this->request_body['quantity'])) {
                $this->http_code = 422;
                throw new \Exception("quantity_param_not_found");
            }

            $items = $transaction->get_by_id($this->request_body['id']);
            $old_quantity = $items->quantity;

            $selected_item = $stock->get_by_id($this->request_body['item_id']);
            $price = $selected_item->price;

            if (empty($items)) {
                $this->http_code = 404;
                throw new \Exception("item_not_found");
            }
            $quantity =  $this->request_body['quantity'];
            $total = $this->request_body['quantity'] * $price;
            if (!$transaction->connection->query("UPDATE transactions SET quantity=$quantity,total=$total WHERE id={$this->request_body['id']}")) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_updated");
            }

            $selected_item = $stock->get_by_id($this->request_body['item_id']);
            $stock_quantity = $selected_item->quantity;

            if ($quantity >= $old_quantity) {
                $def_quantity = $quantity - $old_quantity;
                if ($def_quantity < $stock_quantity) {
                    $stock_quantity = $stock_quantity - $def_quantity;
                } else {
                    die;
                }
            } else {
                $def_quantity = $old_quantity - $quantity;
                $stock_quantity = $stock_quantity + $def_quantity;
            }

            if (!$stock->connection->query("UPDATE stocks SET quantity=$stock_quantity WHERE id={$this->request_body['item_id']}")) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_updated");
            }

            $this->response_schema['message_code'] = "item_updated";
        } catch (\Exception $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
        }
    }


    /**
     * DELETE THE TRANSACTION
     * 
     * @return void
     */
    public function delete()
    {
        try {
            $Transaction = new Transaction;
            if (!isset($this->request_body['id'])) {
                $this->http_code = 422;
                throw new \Exception("id_param_not_found");
            }

            if (!$Transaction->connection->query("DELETE FROM transaction_user WHERE transaction_id={$this->request_body['id']}")) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_deleted");
            }

            $stmt = $Transaction->connection->prepare("DELETE FROM transaction_user WHERE transaction_id=?");
            $stmt->bind_param('i', $this->request_body['id']);
            if (!$stmt->execute()) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_deleted");
            }
            $stmt->close();

            $stmt = $Transaction->connection->prepare("DELETE FROM transactions WHERE id=?");
            $stmt->bind_param('i', $this->request_body['id']);
            if (!$stmt->execute()) {
                $this->http_code = 500;
                throw new \Exception("item_was_not_deleted");
            }
            $stmt->close();

            $this->response_schema['message_code'] = "item_deleted";
        } catch (\Exception $error) {
            $this->response_schema['success'] = false;
            $this->response_schema['message_code'] = $error->getMessage();
        }
    }
}
