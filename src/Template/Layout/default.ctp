<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= h($title);?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->Html->css('/css/generic.css') ?>
    <?= $this->Html->script(['/js/libs/angular.min.js', '/js/libs/jquery-3.2.0.min.js']); ?>
    <?= $this->Html->script(['/js/app.js', '/js/DebtsController.js']); ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
<footer>
</footer>
</body>
</html>
