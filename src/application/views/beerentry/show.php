<?php $page_title="Pokaż - ".HTML::chars($beer->beerName)." - ".HTML::chars($beer->date); require(dirname(__FILE__)."/../_skel/header.php"); ?>

<link rel="stylesheet" type="text/css" href="/files/photoShower/style.css">
<script src="/files/photoShower/script.js"></script>
<div id="photoCanvas"></div>

<style>
    .picrel{
        max-width: 300px;
        max-height: 200px;
    }
</style>

Nazwa piwa i link do ocen-piwo.pl: <?php if ($beer->beerLink=="") echo $beer->beerName; else echo HTML::anchor($beer->beerLink, $beer->beerName) ; ?><br />
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
    if (count($picrel)==0 )
    {
        echo "---<br />";
    }
    else
    {
        foreach ($picrel as $photo) {
            if ($photo=="") continue;
            echo "<img onClick='javascript:showPhoto(\"$photo\")' src='$photo' class='picrel clicker'/><br />";
        }
    }
?>
Notatki:<br />
<cite><?php echo HTML::chars($beer->notes); ?></cite>

<br /><br />
<li><b><?php echo HTML::anchor('mylist', 'Powrót do listy'); ?></b></li>
<li><b><?php echo HTML::anchor('BeerEntry/edit/'.$beer->id, 'Edycja wpisu'); ?></b></li>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>