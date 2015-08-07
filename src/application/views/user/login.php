<?php $page_title="Logowanie"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<h2>Logowanie</h2>
<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>

<?= Form::open('user/login'); ?>

<?= Form::label('username', 'Nazwa użytkownika'); ?>
<?= Form::input('username', HTML::chars(Arr::get($_POST, 'username'))); ?>

<?= Form::label('password', 'Hasło'); ?>
<?= Form::password('password'); ?>

<?= Form::label('remember', 'Pamiętaj mnie'); ?>
<?= Form::checkbox('remember'); ?>

<p>(opcja Pamiętaj mnie utrzymuje sesję 2 tygodnie)</p>

<?= Form::submit('login', 'Login'); ?>
<?= Form::close(); ?>

<p>Lub <?= HTML::anchor('user/create', 'stwórz nowe konto'); ?>. </p>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>