<?php

namespace Core\Model;

use Core\Base\Model;

class Transaction extends Model
{

    /**
     * CHECK THE CURRENT USER LOGGED IN AND THE TODAYS DATE
     * 
     * @return array
     */
    public function check_user_today()
    {
        $id = $_SESSION['user']['user_id'];
        $transaction = new Transaction;
        $data = array();

        $stmt = $transaction->connection->prepare("SELECT * FROM transaction_user WHERE user_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
        }

        $items = array();
        foreach ($data as $transaction_id) {
            $stmt = $transaction->connection->prepare("SELECT * FROM transactions WHERE id=?");
            $stmt->bind_param('i', $transaction_id->id);
            $stmt->execute();
            $result_transaction = $stmt->get_result();
            foreach ($result_transaction as $result_array) {
                $items[] = $result_array;
            }
        }

        $today = date("m/d/Y");

        $item_data = array();
        foreach ($items as $item) {
            $date = new \DateTime($item['created_at']);
            $item['created_at'] = $date->format('m/d/Y');

            if ($today == $item['created_at']) {
                $item_data[] = $item;
            }
        }
        return $item_data;
    }
}
