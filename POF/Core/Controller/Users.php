<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Helpers\Helper;
use Core\Model\User;

class Users extends Controller
{
    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }

    function __construct()
    {
        //CHECK IF THE USER EXISTING
        $this->auth();
    }


    /**
     * GET ALL USERS FROM DATABASE
     * 
     * @return void
     */
    public function index()
    {
        $this->permissions(['user:read']);
        $this->view = 'users.index';
        $user = new User; // new model users
        $this->data['users'] = $user->get_all();
        $this->data['user_count'] = count($user->get_all());
    }

    /**
     *GET THE USER INFORMATION AND DISPLAY IN HTML PROFILE
     * 
     * @return void
     */
    public function profile()
    {
        $this->view = 'users.profile';
        $user = new User;
        $this->data['user'] = $user->get_by_id($_GET['id']);
    }


    /**
     * DISPLAY THE HTML FORM FOR USER CREATION
     * 
     * @return void
     */
    public function create()
    {
        $this->permissions(['user:create']);
        $this->view = 'users.create';
    }

    /**
     * CREATE NEW USER
     * 
     * @return void
     */
    public function store()
    {
        $this->permissions(['user:create']);
        $user = new User;
        //process role
        $permissions = null;
        switch ($_POST['role']) {
            case 'Admin':
                $permissions = User::ADMIN;
                break;

            case 'Seller':
                $permissions = User::SELLER;
                break;

            case 'Procurement':
                $permissions = User::PROCUREMENT;
                break;

            case 'Accountant':
                $permissions = User::ACCOUNTANT;
                break;
        }
        if (!empty($_POST['username']) && !empty($_POST['display_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['role'])) {
            $_POST['permissions'] = \serialize($permissions);
            $_POST['password'] = \password_hash($_POST['password'], PASSWORD_DEFAULT);

            $_POST['username'] = htmlspecialchars($_POST['username']);
            $_POST['display_name'] = htmlspecialchars($_POST['display_name']);
            $_POST['email'] = htmlspecialchars($_POST['email']);
            $_POST['password'] = htmlspecialchars($_POST['password']);
            $user->create($_POST);
            $_SESSION['alert_create'] = "User Create Success";
            Helper::redirect('/users');
        } else {
            $error = $_SESSION['error'] = "Please Fill In The Form";
            Helper::redirect('/users/create');
        }
    }


    /**
     * DISPLAY THE HTML FORM FOR USER UPDATE
     * 
     * @return void
     */
    public function edit()
    {
        $this->view = 'users.edit';
        $user = new User;
        $this->data['user'] = $user->get_by_id($_GET['id']);
    }

    /**
     * UPDATE THE USER
     * 
     * @return void
     */
    public function update()
    {
        $user = new User;
        //process role
        $permissions = null;
        switch ($_POST['role']) {
            case 'admin':
                $permissions = User::ADMIN;
                break;

            case 'seller':
                $permissions = User::SELLER;
                break;

            case 'Procurement':
                $permissions = User::PROCUREMENT;
                break;

            case 'Accountant':
                $permissions = User::ACCOUNTANT;
                break;
        }

        if (!empty($_FILES)) {
            $ext = explode('/', $_FILES['photo']['type']);
            $ext = $ext[array_key_last($ext)];
            $name = $_POST['username'];
            $file_name = "user-$name.$ext";
            $photo = "./photos/$file_name";
            move_uploaded_file($_FILES['photo']['tmp_name'], "./photos/$file_name");
            $_POST['photo'] = $photo;
        }

        $_POST['permissions'] = \serialize($permissions);
        if (!empty($_POST['display_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['role'])) {

            $_POST['username'] = htmlspecialchars($_POST['username']);
            $_POST['display_name'] = htmlspecialchars($_POST['display_name']);
            $_POST['email'] = htmlspecialchars($_POST['email']);
            $user->update($_POST);
            $_SESSION['alert_update'] = "User Updated Success";
            Helper::redirect('/user/profile?id=' . $_POST['id']);
        } else {
            $error = $_SESSION['error'] = "Please do not leave an empty field";
            Helper::redirect('/users/edit?id=' . $_POST['id']);
        }
    }

    /**
     * DELETE THE USER
     * 
     * @return void
     */
    public function delete()
    {
        $this->permissions(['user:read', 'user:delete']);
        $user = new User;
        $user->delete($_GET['id']);
        $_SESSION['alert_delete'] = "User Delete Success";
        Helper::redirect('/users');
    }
}
