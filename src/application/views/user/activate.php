<?php $page_title="Aktywacja konta"; require(dirname(__FILE__)."/../_skel/header.php"); ?>
<h2>Aktywacja konta.</h2>
<? if ($message) : ?>
    <h3 class="message">
        <?= $message; ?>
    </h3>
<? endif; ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>