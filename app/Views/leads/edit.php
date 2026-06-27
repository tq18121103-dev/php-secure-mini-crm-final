<h1>Edit Lead</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/leads/update" class="card form-card">
    <input type="hidden" name="id" value="<?= e((string) $lead['id']) ?>">

    <div>
        <label>Lead Code</label>
        <input
            name="lead_code"
            value="<?= e($old['lead_code'] ?? $lead['lead_code']) ?>"
        >
        <small class="error-text"><?= e($errors['lead_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Full Name</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? $lead['full_name']) ?>"
        >
        <small class="error-text"><?= e($errors['full_name'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? $lead['email']) ?>"
        >
        <small class="error-text"><?= e($errors['email'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Phone</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? $lead['phone']) ?>"
        >
        <small class="error-text"><?= e($errors['phone'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Source</label>
        <input
            name="source"
            value="<?= e($old['source'] ?? $lead['source']) ?>"
        >
        <small class="error-text"><?= e($errors['source'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="status">
            <?php $currentStatus = $old['status'] ?? $lead['status']; ?>

            <?php foreach (['new', 'contacted', 'qualified', 'lost', 'customer'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= ($currentStatus === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Update Lead</button>
    <a href="/leads" style="margin-left: 10px;">Cancel</a>
</form>