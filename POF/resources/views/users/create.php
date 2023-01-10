<div class="h4 pb-2 mb-4 text-success border-bottom border-success mt-3 d-flex justify-content-between had">
    <span> Adding Users <span id="delete_p">to system</span>
        <i class="fa-sharp fa-solid fa-users me-2"></i>
    </span>
    <a href="/users" class="btn btn-danger me-2">
        cancel
    </a>
</div>


<form action="/users/store" method="POST" enctype="multipart/form-data" id="create_form" class="w-50 m-auto p-5 bg-white alert shadow p-3 mb-5 form_form">

    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['error'] ?> </div>
    <?php endif;
    unset($_SESSION['error']);
    ?>

    <div class="mb-2">
        <label for="user_name" class="form-label">User Name</label>
        <input type="text" class="form-control" id="user_name" name="username" required>
    </div>

    <div class="mb-2">
        <label for="display_name" class="form-label">Display Name</label>
        <input type="text" class="form-control" id="display_name" name="display_name" required>
    </div>

    <div class="mb-2">
        <label for="user_email" class="form-label">Email</label>
        <input type="email" class="form-control" id="user_email" name="email" required>
    </div>

    <div class="mb-2">
        <label for="user_password" class="form-label">Password</label>
        <input type="password" class="form-control" id=" user_password" name="password" required>
    </div>

    <div class="mb-3">
        <label for="user-role" class="form-label">Role</label>
        <select class="form-select" aria-label="Role" name="role">
            <option value="Admin">Admin</option>
            <option value="Seller">Seller</option>
            <option value="Procurement">Procurement</option>
            <option value="Accountant">Accountant</option>
        </select>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">Create</button>
    </div>

</form>
