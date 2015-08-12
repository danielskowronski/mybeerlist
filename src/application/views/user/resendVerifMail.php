<?php $page_title="Ponowne wysłanie maila aktywującego"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<?php echo Form::open('user/resendVerifMail'); ?>

<?php echo Form::label('email', "Email"); ?>
<?php echo Form::input('email'); ?><br />

<?php echo Form::submit('save', 'Wyślij'); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>