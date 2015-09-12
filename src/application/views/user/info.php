<?php $page_title="Moje konto - ".$user->username; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<img src="<?= Helper_User::gravatarUrl($user) ?>" /><br />

<ul>
    <li>Email: <?= $user->email; ?></li>
    <li>Liczba logowań: <?= $user->logins; ?></li>
    <li>Ostatnie logowanie: <?= Date::fuzzy_span($user->last_login); ?></li>
    <li>Ustawienia publikowania:<br />
        <strong>główna lista</strong><br />
        <?php foreach (Helper_PublicLevel::decodePublicLevel($user->publicLevel) as $key => $value): ?>
            <?= Helper_PublicLevel::translateRawPublicityName($key); ?>: <?= ($value===true) ? "&#10004" : "&#10006" ?><br />
        <?php endforeach; ?>
        <strong>lista życzeń</strong><br />
        <?php foreach (Helper_PublicLevelOfWanted::decodePublicLevel($user->publicLevelOfWanted) as $key => $value): ?>
            <?= Helper_PublicLevelOfWanted::translateRawPublicityName($key); ?>: <?= ($value===true) ? "&#10004" : "&#10006" ?><br />
        <?php endforeach; ?>
    </li>
</ul>

<?= HTML::anchor('user/edit', 'Zmiana ustawień'); ?><br />
<?= HTML::anchor('user/password', 'Zmiana hasła'); ?><br />
<?= HTML::anchor('user/logout', 'Wyloguj się'); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>