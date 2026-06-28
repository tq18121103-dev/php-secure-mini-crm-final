<h1>Edit Order</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/orders/update" class="card form-card">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= e((string) $order['id']) ?>">

    <div>
        <label>Order Code</label>
        <input
            name="order_code"
            value="<?= e($old['order_code'] ?? $order['order_code']) ?>"
        >
        <small class="error-text"><?= e($errors['order_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Lead ID</label>
        <input
            name="lead_id"
            value="<?= e($old['lead_id'] ?? (string) $order['lead_id']) ?>"
        >
        <small class="error-text"><?= e($errors['lead_id'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Amount</label>
        <input
            type="number"
            step="1000"
            name="amount"
            value="<?= e($old['amount'] ?? (string) $order['amount']) ?>"
        >
        <small class="error-text"><?= e($errors['amount'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="order_status">
            <?php $currentStatus = $old['order_status'] ?? $order['order_status']; ?>

            <?php foreach (['pending', 'paid', 'cancelled'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= ($currentStatus === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['order_status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Update Order</button>
    <a href="/orders" style="margin-left: 10px;">Cancel</a>
</form>