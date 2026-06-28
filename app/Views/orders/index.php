<h1>Order List</h1>

<a class="btn" href="/orders/create">Create Order</a>

<br><br>

<form method="get" action="/orders" class="search-form">
    <?= csrf_field() ?>
    <input
        type="text"
        name="keyword"
        value="<?= e($keyword ?? '') ?>"
        placeholder="Search by order code, lead name, status"
    >

    <button type="submit">Search</button>
    <a href="/orders">Reset</a>
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th><a href="/orders?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC">ID</a></th>
        <th><a href="/orders?keyword=<?= e($keyword ?? '') ?>&sort=order_code&direction=ASC">Order Code</a></th>
        <th>Lead</th>
        <th><a href="/orders?keyword=<?= e($keyword ?? '') ?>&sort=amount&direction=DESC">Amount</a></th>
        <th><a href="/orders?keyword=<?= e($keyword ?? '') ?>&sort=order_status&direction=ASC">Status</a></th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php if (empty($orders)): ?>
        <tr>
            <td colspan="7">No orders found.</td>
        </tr>
    <?php endif; ?>

    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= e((string) $order['id']) ?></td>
            <td><?= e($order['order_code']) ?></td>
            <td><?= e($order['lead_name'] ?? 'Unknown Lead') ?></td>
            <td><?= e(number_format((float) $order['amount'])) ?> VND</td>
            <td><?= e($order['order_status']) ?></td>
            <td><?= e($order['created_at']) ?></td>
            <td>
                <a href="/orders/edit?id=<?= e((string) $order['id']) ?>">Edit</a>

                <form
                    method="post"
                    action="/orders/delete"
                    style="display:inline;"
                    onsubmit="return confirm('Delete this order?');"
                >
                    <input type="hidden" name="id" value="<?= e((string) $order['id']) ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br>

<?php if (($totalPages ?? 1) > 1): ?>
    <div>
        Pages:

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
                href="/orders?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                style="<?= ($i === ($page ?? 1)) ? 'font-weight:bold; color:red;' : '' ?>"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>