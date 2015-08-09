<?php $page_title="Resetuj hasło"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<h1>Resetuj hasło </h1>
<?php if (isset($message)): ?><h2><?php echo $message; ?></h2><?php endif;?>

<script>
    function validatePassword(){
        if ($("input[name=newpass1]").val() != $("input[name=newpass2]").val()){
            alert("Hasła się nie zgadzają!");
            return false;
        }
        if ($("input[name=newpass1]").val().length < 8){
            alert("Hasło za krótkie!");
            return false;
        }
        return true;
    }

</script>

<?php echo Form::open('user/reset'); ?>

<?php echo Form::label('login', "Login"); ?>
<?php echo Form::input('login'); ?><br />

<?php echo Form::label('newpass1', "Nowe hasło"); ?>
<?php echo Form::password('newpass1'); ?><br />

<?php echo Form::label('newpass2', "Nowe hasło (jeszcze raz)"); ?>
<?php echo Form::password('newpass2'); ?><br />

<?php echo Form::hidden('token', $token); ?><br />

<?php echo Form::submit('save', 'Zapisz', array("onClick"=>"return validatePassword();")); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>