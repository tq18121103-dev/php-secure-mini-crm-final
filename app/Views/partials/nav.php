<header class="topbar">
    <strong>Secure Mini CRM</strong>

    <nav>
        <a href="/">Home</a>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="/dashboard">Dashboard</a>
            <a href="/leads">Leads</a>
            <a href="/orders">Orders</a>

            <form method="post" action="/logout" style="display:inline;">
                <button type="submit" class="link-button">Logout</button>
            </form>
        <?php else: ?>
            <a href="/login">Login</a>
        <?php endif; ?>

        <a href="/health">Health</a>
    </nav>
</header>