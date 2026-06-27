<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Secure Mini CRM') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<?php partial('nav'); ?>

<main class="container">
    <?php partial('flash'); ?>

    <?= $content ?>
</main>

</body>
</html>