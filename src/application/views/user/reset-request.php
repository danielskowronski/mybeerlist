<?php $page_title="Resetuj hasło"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<h1>Resetuj hasło </h1>
<?php if (isset($message)): ?><h2><?php echo $message; ?></h2><?php endif;?>

<?php echo Form::open('user/reset'); ?>

<?php echo Form::label('login', "Login"); ?>
<?php echo Form::input('login'); ?><br />

<?php echo Form::label('email', "Email"); ?>
<?php echo Form::input('email'); ?><br />

<?php echo Form::submit('save', 'Resetuj', array("onClick"=>"return validatePassword();")); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>