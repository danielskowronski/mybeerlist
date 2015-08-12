<?php $page_title="Publiczne listy"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<ul>
<?php foreach($beerlists as $beerlist): ?>
    <li>
        <?php echo HTML::anchor('BeerList/show/'.$beerlist->id, "
            <img src='".HTML::chars($beerlist->avatarUrl)."' height='20'/>".
            HTML::chars($beerlist->username) ); ?>
    </li>
<?php endforeach; ?>
</ul>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>