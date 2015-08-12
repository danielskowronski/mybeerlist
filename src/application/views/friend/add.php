<?php $page_title="Dodaj przyjaciela"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

    <script src="/files/variaScripts/password.js"></script>

<?php echo Form::open('friend/add'); ?>

<?php echo Form::label('login', "Login przyjaciela"); ?>
<?php echo Form::input('login'); ?><br />

<?php echo Form::submit('save', 'Dodaj'); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>