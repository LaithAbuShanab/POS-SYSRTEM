<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Helpers\Helper;
use Core\Model\User;

class Authentication extends Controller
{

    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }

    function __construct()
    {
        if (isset($_SESSION['user'])) {
            Helper::redirect('./dashboard');
        }
    }

    /**
     * DISPLAY LOGIN FORM
     * 
     * @return void
     */
    public function login()
    {
        $this->view = "login";
    }

    /**
     *LOGIN VALIDATION
     * 
     * @return void
     */
    public function validate()
    {
        $user = new User;
        $password = $_POST['password'];
        $logged_in_user = $user->check_username($_POST['username']);
        if (!$logged_in_user) {
            $this->invalid_redirect();
        }

        if (strlen($password) < 8 || strlen($password) > 15) {
            $this->invalid_redirect();
        }

        if (!\password_verify($_POST['password'], $logged_in_user->password)) {
            $this->invalid_redirect();
        }

        if (isset($_POST['remember_me'])) {
            \setcookie('user_id', $logged_in_user->id, time() + (86400 * 30));
        }

        $_SESSION['user'] = array(
            'username' => $logged_in_user->username,
            'display_name' => $logged_in_user->display_name,
            'user_id' => $logged_in_user->id,
            'is_admin_view' => true,
            "role" => $logged_in_user->role,
            "photo"=>$logged_in_user->photo
        );

        $user->active();


        if (Helper::check_permission(['user:read'])) {
            Helper::redirect('/dashboard');
            exit();
        }

        if (Helper::check_permission(['selling:read'])) {
            Helper::redirect('/selling');
            exit();
        }

        if (Helper::check_permission(['stock:read'])) {
            Helper::redirect('/stocks');
            exit();
        }

        if (Helper::check_permission(['transaction:read'])) {
            Helper::redirect('/transactions');
            exit();
        }
    }

    /**
     * LOGOUT VALIDATION
     * 
     * @return void
     */
    public function logout()
    {
        $user = new User;
        $user->inactive();
        \session_destroy();
        \session_unset();
        \setcookie("user_id", "", time() - 3600);
        Helper::redirect('/');
    }

    /**
     * IF USER DOES'T EXISTING 
     * 
     * @return void
     */
    private function invalid_redirect()
    {
        $_SESSION['error'] = "incorrect Password or Email!!";
        Helper::redirect('/');
        exit;
    }
}
