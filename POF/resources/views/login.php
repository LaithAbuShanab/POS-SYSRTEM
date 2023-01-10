<div class="login_center">
    <h1>Login</h1>
    <form method="post" action="/authenticate">
        <div class="user_field">
            <input type="text" name="username" required>
            <span></span>
            <label for="">
                <i class="bi bi-person-fill"></i>
                Username</label>
        </div>
        <div class="user_field">
            <input type="password" name="password" required>
            <span></span>
            <label for="">
                <i class="bi bi-lock-fill"></i>
                Password</label>
        </div>
        <?php if (!isset($_SESSION['user']) && isset($_SESSION['error'])) : ?>
            <p><?= $_SESSION['error'] ?></p>
        <?php endif;
        unset($_SESSION['error']);
        ?>
        <div class="check_field">
            <input type="checkbox" name="remember_me">
            <label for="">Remember Me</label>
        </div>
        <button type="submit">Login</button>
    </form>
</div>