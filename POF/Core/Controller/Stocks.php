<?php

namespace Core\Controller;

use Core\Base\Controller;
use Core\Helpers\Helper;
use Core\Model\Stock;

class Stocks extends Controller
{
    public function render()
    {
        if (!empty($this->view))
            $this->view();
    }

    function __construct()
    {
        $this->auth();
    }


    /**
     * GET ALL ITEMS FROM DATABASE
     * 
     * @return void
     */
    public function index()
    {
        $this->permissions(['stock:read']);
        $this->view = 'stocks.index';
        $stock = new Stock; // new model posts
        $data = $this->data['items'] = $stock->get_all();
        $this->data['stock_count'] = count($stock->get_all());
    }

    /**
     * DISPLAY THE HTML FORM FOR ITEM CREATION
     * 
     * @return void
     */
    public function create()
    {
        $this->permissions(['stock:read']);
        $this->view = 'stocks.create';
    }

    /**
     * CREATE NEW ITEM
     * 
     * @return void
     */
    public function store()
    {
        $this->permissions(['stock:create']);
        $stock = new Stock;
        if (!empty($_FILES)) {
            $ext = explode('/', $_FILES['photo']['type']);
            $ext = $ext[array_key_last($ext)];
            $name = $_POST['name'];
            $file_name = "item-$name.$ext";
            $photo = "./photos/$file_name";
            move_uploaded_file($_FILES['photo']['tmp_name'], "./photos/$file_name");
            $_POST['photo'] = $photo;
        }
        if (!empty($_POST['name']) && !empty($_POST['cost']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {
            $_POST['name'] = \htmlspecialchars($_POST['name']);
            $_POST['cost'] = \htmlspecialchars($_POST['cost']);
            $_POST['price'] = \htmlspecialchars($_POST['price']);
            $_POST['quantity'] = \htmlspecialchars($_POST['quantity']);
            $stock->create($_POST);
            $_SESSION['alert_create'] = "Item Create Success";
            Helper::redirect('/stocks');
        } else {
            $error = $_SESSION['error'] = "Please Fill In The Form";
            Helper::redirect('/stocks/create');
        }
    }

    /**
     * DISPLAY THE HTML FORM FOR ITEM UPDATE
     * 
     * @return void
     */
    public function edit()
    {
        $this->permissions(['stock:read', 'stock:update']);
        $this->view = 'stocks.edit';
        $stock = new Stock;
        $selected_item = $stock->get_by_id($_GET['id']);
        $this->data['item'] =  $selected_item;
    }

    /**
     * UPDATE THE ITEM
     * 
     * @return void
     */
    public function update()
    {
        $this->permissions(['stock:read', 'stock:update']);
        $stock = new Stock;
        if (!empty($_POST['name']) && !empty($_POST['cost']) && !empty($_POST['price'])) {
            $_POST['name'] = \htmlspecialchars($_POST['name']);
            $_POST['cost'] = \htmlspecialchars($_POST['cost']);
            $_POST['price'] = \htmlspecialchars($_POST['price']);
            $_POST['quantity'] = \htmlspecialchars($_POST['quantity']);
            $stock->update($_POST);
            $_SESSION['alert_update'] = "Item Updated Success";
            Helper::redirect('/stocks');
        } else {
            $error = $_SESSION['error'] = "Please do not leave an empty field";
            Helper::redirect('/stocks/edit?id=' . $_POST['id']);
        }
    }

    /**
     * DELETE THE ITEM
     * 
     * @return void
     */
    public function delete()
    {
        $this->permissions(['stock:read', 'stock:delete']);
        $stock = new Stock;
        $stock->delete($_GET['id']);
        $_SESSION['alert_delete'] = "Item Delete Success";
        Helper::redirect('/stocks');
    }
}
