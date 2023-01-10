<?php

use Core\Helpers\Helper;

?>

<div class="h4 pb-2 mb-4 text-warning border-bottom border-warning mt-3 d-flex justify-content-between had">
    <span> Updating Users <span id="delete_p"> in system</span>
        <i class="fa-sharp fa-solid fa-users me-2"></i>
    </span>
    <a href="/user/profile?id=<?= $data->user->id  ?>" class="btn btn-danger me-2">
        cancel
    </a>
</div>

<form action="/users/update" method="POST" enctype="multipart/form-data" class="w-50 m-auto p-5 bg-white alert shadow p-3 mb-5 form_form">

    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['error'] ?> </div>
    <?php endif;
    unset($_SESSION['error']);
    ?>


    <input type="hidden" name="id" value="<?= $data->user->id ?>">
    <div class="mb-3">
        <label for="display-name" class="form-label">Display Name</label>
        <input type="text" value="<?= $data->user->display_name ?>" class="form-control" id="display-name" aria-describedby="emailHelp" name="display_name" required>
    </div>

    <div class="mb-3">
        <label for="user-email" class="form-label">Email</label>
        <input type="email" value="<?= $data->user->email ?>" class="form-control" id="user-email" aria-describedby="emailHelp" name="email" required>
    </div>

    <div class="mb-3">
        <label for="phone-email" class="form-label">Phone</label>
        <input type="text" value="<?= $data->user->phone ?>" class="form-control" id="phone-email" name="phone" required>
    </div>

    <div class="mb-3">
        <label for="user-name" class="form-label">User Name</label>
        <input type="text" value="<?= \htmlspecialchars($data->user->username) ?>" class="form-control" id="user-name" aria-describedby="emailHelp" name="username" required>
    </div>

    <div class="mb-3">
        <label for="user-role" class="form-label">Role</label>
        <select class="form-select" aria-label="Role" name="role">
            <?php if (Helper::check_permission(['user:read'])) : ?>
                <option value="admin">Admin</option>
            <?php endif; ?>
            <?php if (Helper::check_permission(['selling:read'])) : ?>
                <option value="seller">Seller</option>
            <?php endif; ?>
            <?php if (Helper::check_permission(['stock:read'])) : ?>
                <option value="Procurement">Procurement</option>
            <?php endif; ?>
            <?php if (Helper::check_permission(['transaction:read'])) : ?>
                <option value="Accountant">Accountant</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="mb-2">
        <label for="user_photo" class="form-label">user photo</label>
        <input type="file" class="form-control" id="user_photo" name="photo">
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-warning">Update</button>
    </div>
</form>