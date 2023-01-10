<?php

namespace Core\Base;

class Model
{
    public $connection;
    public $table;

    public function __construct()
    {
        $this->connection();
        $this->relate_table();
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * GET ALL DATA FROM DATABASE
     * 
     * @return ARRAY
     */
    public function get_all()
    {
        $data = array();
        $stmt = $this->connection->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[] = $row;
            }
        }
        return $data;
    }


    /**
     * GET SINGLE DATA
     * 
     * @param array $id
     * @return OBJECT
     */
    public function get_by_id($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM $this->table WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_object();
    }


    /**
     * DELETE THE SINGLE DATA
     * 
     * @param array $id
     * @return void
     */
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id=?";
        $stmt = $this->connection->stmt_init();
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * CREATE NEW DATA
     * 
     * @param array $data
     * @return void
     */
    public function create($data)
    {
        $keys = '';
        $values = '';
        $data_types = '';
        $value_arr = array();

        foreach ($data as $key => $value) {
            if ($key != \array_key_last($data)) {
                $keys .= $key . ', ';
                $values .= "?, ";
            } else {
                $keys .= $key;
                $values .= "?";
            }

            switch ($key) {
                case 'id':
                case 'user_id':
                case 'transaction_id':
                    $data_types .= "i";
                    break;

                default:
                    $data_types .= "s";
                    break;
            }

            $value_arr[] = $value;
        }

        $sql = "INSERT INTO $this->table ($keys) VALUES($values)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($data_types, ...$value_arr);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * UPDATE NEW DATA
     * 
     * @param array $data
     * @return void
     */
    public function update($data)
    {
        $set_values = '';
        $data_types = '';
        $id = 0;
        $values_array = array();
        $id_bind = "";

        foreach ($data as $key => $value) {
            if ($key == 'id') {
                $id = "?";
                $id_bind = $value;
                continue;
            }
            if ($key != \array_key_last($data)) {
                $set_values .= "$key= ?, ";
            } else {
                $set_values .= "$key= ?";
            }

            switch ($key) {
                case 'id':
                case 'user_id':
                case 'transaction_id':
                    $data_types .= "i";
                    break;

                default:
                    $data_types .= "s";
                    break;
            }

            $values_array[] = "$value";
        }
        $values_array[] = $id_bind;
        $data_types .= "i";
        $sql = "UPDATE $this->table
            SET $set_values
            WHERE id=$id
        ";


        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($data_types, ...$values_array);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * CHECK CONNECTION DATABASE
     * 
     * @return void
     */
    protected function connection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "POS";

        $this->connection = new \mysqli($servername, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function last($table)
    {
        $data = array();
        $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $data[] = $row->id;
            }
            return $data;
        }
    }


    /**
     * CHECK TABLE NAME TO CALL TABLE FROM DATA
     * 
     * @return void
     */
    protected function relate_table()
    {
        $table_name = \get_class($this);
        $table_name_arr = \explode('\\', $table_name);
        $class_name = \strtolower($table_name_arr[\array_key_last($table_name_arr)] . 's');
        $this->table = $class_name;
    }
}
