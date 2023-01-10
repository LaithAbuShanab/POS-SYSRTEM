<?php

use Core\Helpers\Helper;

$title = explode('/', $_SERVER['REQUEST_URI']);
$title = $title[1];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= "http://" . $_SERVER['HTTP_HOST'] ?>/resources/css/admin.css">
    <title><?= $title ?></title>
</head>

<body class="admin-view">

    <div class="row w-100 m-0" id="admin-area">
        <div class="col-2 ps-0 pt-3 admin-links">
            <ul class="list-group">
                <?php if (Helper::check_permission(['dashboard:read'])) : ?>
                    <li class="list-group-item">
                        <a href="/dashboard" class="pt-0">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <br>
                    <br>
                <?php endif;
                if (Helper::check_permission(['selling:read'])) :
                ?>
                    <li class="list-group-item">
                        <a href="/selling">
                            <i class="fa-solid fa-cart-shopping me-2"></i>
                            <span>Selling</span></a>
                    </li>
                <?php endif;
                if (Helper::check_permission(['stock:read'])) :
                ?>

                    <li class="list-group-item">
                        <a href="/stocks">
                            <i class="fa-solid fa-warehouse me-2"></i>
                            <span>All Items</span></a>
                    </li>

                    <li class="list-group-item">
                        <a href="/stocks/create">
                            <i class="fa-solid fa-cart-plus me-2"></i>
                            <span>Add Item</span></a>
                    </li>
                <?php endif;
                if (Helper::check_permission(['transaction:read'])) :
                ?>
                    <li class="list-group-item">
                        <a href="/transactions">
                            <i class="fa-solid fa-right-left me-2"></i>
                            <span>Transactions</span></a>
                    </li>
                <?php endif;
                if (Helper::check_permission(['user:read'])) :
                ?>

                    <li class="list-group-item">
                        <a href="/users">
                            <i class="fa-sharp fa-solid fa-users me-2"></i>
                            <span>All Users</span></a>
                    </li>

                    <li class="list-group-item">
                        <a href="/users/create">
                            <i class="fa-solid fa-user-plus me-2"></i>
                            <span>Create Users</span></a>
                    </li>

                <?php endif ?>
            </ul>
        </div>

        <div id="body_box" class="col-10 p-0 nav_h">
            <nav class="navbar" id="header_top">
                <div class="container-fluid">
                    <p class="navbar-brand text-white mb-0"><i class="fa-solid fa-cash-register" id="dashboard_card"></i> POS SYSTEM</p>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?= $_SESSION['user']['display_name'] ?>
                                <span class="badge text-bg-<?= $_SESSION['user']['role'] == "Admin" ? "primary" : "success" ?>"><?= $_SESSION['user']['role'] ?></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/dashboard">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/user/profile?id=<?= $_SESSION['user']['user_id']  ?>">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/logout">Logout</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </nav>
            <div class="container body">