<h1>Create Lead</h1>

<?php if (!empty($errors['general'])): ?>
    <div class="alert error">
        <?= e($errors['general']) ?>
    </div>
<?php endif; ?>

<form method="post" action="/leads" class="card form-card">
    <div>
        <label>Lead Code</label>
        <input
            name="lead_code"
            value="<?= e($old['lead_code'] ?? '') ?>"
            placeholder="LD011"
        >
        <small class="error-text"><?= e($errors['lead_code'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Full Name</label>
        <input
            name="full_name"
            value="<?= e($old['full_name'] ?? '') ?>"
            placeholder="Nguyen Van A"
        >
        <small class="error-text"><?= e($errors['full_name'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Email</label>
        <input
            name="email"
            value="<?= e($old['email'] ?? '') ?>"
            placeholder="lead@example.com"
        >
        <small class="error-text"><?= e($errors['email'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Phone</label>
        <input
            name="phone"
            value="<?= e($old['phone'] ?? '') ?>"
            placeholder="0901234567"
        >
        <small class="error-text"><?= e($errors['phone'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Source</label>
        <input
            name="source"
            value="<?= e($old['source'] ?? '') ?>"
            placeholder="Facebook / Website / Referral"
        >
        <small class="error-text"><?= e($errors['source'] ?? '') ?></small>
    </div>

    <br>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="">Choose status</option>

            <?php foreach (['new', 'contacted', 'qualified', 'lost', 'customer'] as $status): ?>
                <option
                    value="<?= e($status) ?>"
                    <?= (($old['status'] ?? '') === $status) ? 'selected' : '' ?>
                >
                    <?= e(ucfirst($status)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="error-text"><?= e($errors['status'] ?? '') ?></small>
    </div>

    <br>

    <button type="submit">Create Lead</button>
    <a href="/leads" style="margin-left: 10px;">Cancel</a>
</form>