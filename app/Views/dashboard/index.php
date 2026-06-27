<h1>Dashboard</h1>

<p>
    Welcome, <strong><?= e($_SESSION['username'] ?? 'User') ?></strong>.
</p>

<div class="cards">
    <div class="card">
        <h2>Leads</h2>
        <p>Manage lead list, search, pagination, create, update, delete.</p>
    </div>

    <div class="card">
        <h2>Orders</h2>
        <p>Manage orders, unique order code, payment status.</p>
    </div>

    <div class="card">
        <h2>Security</h2>
        <p>Session login, regenerate ID, timeout, safe logout.</p>
    </div>
</div>