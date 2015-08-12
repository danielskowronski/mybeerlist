<?php $page_title="Resetuj hasło"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<script src="/files/variaScripts/password.js"></script>

<?php echo Form::open('user/reset'); ?>

<?php echo Form::label('login', "Login"); ?>
<?php echo Form::input('login'); ?><br />

<?php echo Form::label('password', "Nowe hasło"); ?>
<?php echo Form::password('password'); ?><br />

<?php echo Form::label('password_confirm', "Nowe hasło (jeszcze raz)"); ?>
<?php echo Form::password('password_confirm'); ?><br />

<?php echo Form::hidden('token', $token); ?><br />

<?php echo Form::submit('save', 'Zapisz', array("onClick"=>"return validatePassword();")); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>