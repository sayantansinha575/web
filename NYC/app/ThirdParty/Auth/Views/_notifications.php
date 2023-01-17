<?php if (session()->has('success')) : ?>
    <div class=" text-success notification success">
        <?= session('success') ?>
    </div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
    <div class=" text-danger notification error">
        <?= session('error') ?>
    </div>
<?php endif ?>

<?php if (session()->has('errors')) : ?>
    <ul class=" text-danger notification error">
    <?php foreach (session('errors') as $error) : ?>
        <li><?= $error ?></li>
    <?php endforeach ?>
    </ul>
<?php endif ?>
