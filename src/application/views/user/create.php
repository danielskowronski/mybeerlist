<?php $page_title="Tworzenie konta"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<script src="/files/variaScripts/password.js"></script>

<?= Form::open('user/create'); ?>

<?= Form::label('username', 'Nazwa użytkowika'); ?>
<?= Form::input('username', HTML::chars(Arr::get($_POST, 'username'))); ?>
<div class="error">
    <?= Arr::get($errors, 'username'); ?>
</div>

<?= Form::label('email', 'Email'); ?>
<?= Form::input('email', HTML::chars(Arr::get($_POST, 'email'))); ?>
<div class="error">
    <?= Arr::get($errors, 'email'); ?>
</div>

<?= Form::label('password', 'Hasło'); ?>
<?= Form::password('password'); ?>
<div class="error">
    <?= Arr::path($errors, '_external.password'); ?>
</div>

<?= Form::label('password_confirm', 'Potwierdź hasło'); ?>
<?= Form::password('password_confirm'); ?>
<div class="error">
    <?= Arr::path($errors, '_external.password_confirm'); ?>
</div>

<?= Form::submit('create', 'Utwórz konto', array("onClick"=>"return validatePassword();")); ?>
<?= Form::close(); ?>

<p>Lub <?= HTML::anchor('user/login', 'zaloguj się'); ?> jeśli już posiadasz u nas konto.</p>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>