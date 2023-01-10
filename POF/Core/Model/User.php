<?php


namespace Core\Model;

use Core\Base\Model;

class User extends Model
{

    const ADMIN = array(
        "dashboard:read",
        "user:read", "user:create", "user:update", "user:delete",
        "selling:read", "selling:create", "selling:update", "selling:delete",
        "stock:read", "stock:create", "stock:update", "stock:delete",
        "transaction:read", "transaction:create", "transaction:update", "transaction:delete"
    );

    const SELLER = array(
        "selling:read", "selling:create", "selling:update", "selling:delete",
    );

    const  PROCUREMENT = array(
        "stock:read", "stock:create", "stock:update", "stock:delete",
    );

    const ACCOUNTANT = array(
        "transaction:read", "transaction:create", "transaction:update", "transaction:delete",
    );

    /**
     * CHECK THE USERNAME 
     * 
     * @param string $username
     * @return object
     */
    public function check_username(string $username)
    {
        $stmt = $this->connection->prepare("SELECT * FROM $this->table WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($result->num_rows > 0) {
                return $result->fetch_object();
            } else {
                return false;
            }
        } else {
            return false;
        }
        $stmt->close();
    }

    /**
     * GET THE PERMISSION FOR USER
     * 
     * @return array
     */
    public function get_permission(): array
    {
        $permission = array();
        $user = $this->get_by_id($_SESSION['user']['user_id']);

        if ($user) {
            $permission = \unserialize($user->permissions);
        }
        return $permission;
    }

    public function active()
    {
        $sql = "UPDATE users set active = 1 where id=" . $_SESSION['user']['user_id'];
        $this->connection->query($sql);
    }

    public function inactive()
    {
        $sql = "UPDATE users set active = 0 where id=" . $_SESSION['user']['user_id'];
        $this->connection->query($sql);
    }
}
