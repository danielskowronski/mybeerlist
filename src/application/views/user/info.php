<?php $page_title="Moje konto"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<h2>Moje konto - "<?= $user->username; ?>"</h2>
<img src="<?= $user->avatarUrl; ?>" style="max-width: 200px;" /><br />

<ul>
    <li>Email: <?= $user->email; ?></li>
    <li>Liczba logowań: <?= $user->logins; ?></li>
    <li>Ostatnie logowanie: <?= Date::fuzzy_span($user->last_login); ?></li>
    <li>Ustawienia publikowania:<br />

        <?php foreach (Helper_PublicLevel::decodePublicLevel($user->publicLevel) as $key => $value): ?>
            <?= $key; ?>: <?= ($value===true) ? "&#10004" : "&#10006" ?><br />
        <?php endforeach; ?>
    </li>
</ul>

<?= HTML::anchor('user/edit', 'Zmiana ustawień'); ?><br />
<?= HTML::anchor('user/logout', 'Wyloguj się'); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>