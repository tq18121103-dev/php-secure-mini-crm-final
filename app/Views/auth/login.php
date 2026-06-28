<h1>Login</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/login" class="card form-card">
    <?= csrf_field() ?>
    <div>
        <label>Username</label>
        <input
            name="username"
            value="<?= e($old['username'] ?? '') ?>"
            placeholder="admin"
        >
        <small class="error-text"><?= e($errors['username'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Password</label>
        <input
            type="password"
            name="password"
            placeholder="123456"
        >
        <small class="error-text"><?= e($errors['password'] ?? '') ?></small>
    </div>

    <br>

    <label>
        <input type="checkbox" name="remember" value="1">
        Remember me
    </label>

    <p class="muted">
        Demo account: admin / 123456
    </p>

    <button type="submit">Login</button>
</form>