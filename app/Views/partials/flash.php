<?php if ($message = get_flash('success')): ?>
    <div class="alert success"><?= e($message) ?></div>
<?php endif; ?>

<?php if ($message = get_flash('error')): ?>
    <div class="alert error"><?= e($message) ?></div>
<?php endif; ?>