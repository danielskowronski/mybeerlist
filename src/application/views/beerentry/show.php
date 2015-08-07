<?php require(dirname(__FILE__)."/../_skel/header.php"); ?>

<link rel="stylesheet" type="text/css" href="/files/photoShower/style.css">
<script src="/files/photoShower/script.js"></script>
<div id="photoCanvas"></div>

<style>
    .picrel{
        max-width: 300px;
        max-width: 200px;
    }
</style>

<h1>Pokaż - <?php echo HTML::chars($beer->beerName); ?> - <?php echo HTML::chars($beer->date); ?></h1>

Nazwa piwa i link do ocen-piwo.pl: <a href="<?php echo HTML::chars($beer->beerLink); ?>"><?php echo HTML::chars($beer->beerName); ?></a><br />
<?php $wypiteShown=false; if(!empty($beer->location)): ?>
    wypite w <em><?php echo HTML::chars($beer->location); $wypiteShown=true; ?></em>
<?php endif; if(!empty($beer->companions)): ?>
    <?php if (!$wypiteShown) echo "wypite"; ?>
    z <em><?php echo HTML::chars($beer->companions);  $wypiteShown=true;?></em>
<?php endif; if(!empty($beer->date)): ?>
    <?php if (!$wypiteShown) echo "wypite"; ?>
    dnia <em><?php echo HTML::chars($beer->date); ?></em>.<br />
Ocena dla tego rekordu to: <em><?php echo HTML::chars($beer->rating); ?></em>
<?php endif; ?>.<br />
Pic related:<br />
<?php
    $picrel = preg_split("/\s/", $beer->photosUrls);
    if (count($picrel)==0) echo "---";
    foreach ($picrel as $photo) {
        echo "<img onClick='javascript:showPhoto(\"$photo\")' src='$photo' class='picrel clicker'/><br />";
    }
?>
Notatki:<br />
<?php echo HTML::chars($beer->notes); ?>

<br /><br />
<li><b><?php echo HTML::anchor('BeerEntry/list', 'Powrót do listy'); ?></b></li>
<li><b><?php echo HTML::anchor('BeerEntry/edit/'.$beer->id, 'Edycja wpisu'); ?></b></li>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>