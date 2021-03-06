<?php $page_title="Edytuj konto"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<?php echo Form::open('user/edit'); ?>

<?php echo Form::label('username', "Nazwa użytkownika"); ?>
<?php echo Form::input('username', $user->username); ?><br />

<?php echo Form::label('email', "Email"); ?>
<?php echo Form::input('email', $user->email); ?><br />

Avatar z gravatara:<br /> <img src="<?= Helper_User::gravatarUrl($user) ?>" /><br /><br />

Ustawienia publikowania:<br />
<strong>główna lista</strong><br />
<?php foreach (Helper_PublicLevel::decodePublicLevel($user->publicLevel) as $key => $value): ?>
    <?php echo Form::checkbox('publicLevel[]', $key, $value); echo Helper_PublicLevel::translateRawPublicityName($key); ?><br />
<?php endforeach; ?>
<strong>lista życzeń</strong><br />
<?php foreach (Helper_PublicLevelOfWanted::decodePublicLevel($user->publicLevelOfWanted) as $key => $value): ?>
    <?php echo Form::checkbox('publicLevelOfWanted[]', $key, $value); echo Helper_PublicLevelOfWanted::translateRawPublicityName($key); ?><br />
<?php endforeach; ?>

<?php echo Form::submit('save', 'Zapisz'); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>