<?php $page_title="Edytuj hasło"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<script src="/files/variaScripts/password.js"></script>

<?php echo Form::open('user/password'); ?>

<?php echo Form::label('oldpass', "Stare hasło"); ?>
<?php echo Form::password('oldpass'); ?><br />

<?php echo Form::label('password', "Nowe hasło"); ?>
<?php echo Form::password('password'); ?><br />

<?php echo Form::label('password_confirm', "Nowe hasło (jeszcze raz)"); ?>
<?php echo Form::password('password_confirm'); ?><br />

<?php echo Form::submit('save', 'Zapisz', array("onClick"=>"return validatePassword();")); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>