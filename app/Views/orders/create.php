<h1>Create Order</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/orders" class="card form-card">
    <?= csrf_field() ?>
    <div>
        <label>Order Code</label>
        <input
            name="order_code"
            value="<?= e($old['order_code'] ?? '') ?>"
            placeholder="OD011"
        >
        <small class="error-text"><?= e($errors['order_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Lead ID</label>
        <input
            name="lead_id"
            value="<?= e($old['lead_id'] ?? '') ?>"
            placeholder="1"
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
            value="<?= e($old['amount'] ?? '') ?>"
            placeholder="1500000"
        >
        <small class="error-text"><?= e($errors['amount'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="order_status">
            <option value="">Choose status</option>

            <?php foreach (['pending', 'paid', 'cancelled'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= (($old['order_status'] ?? '') === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['order_status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Create Order</button>
    <a href="/orders" style="margin-left: 10px;">Cancel</a>
</form>