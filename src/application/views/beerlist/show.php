<?php require(dirname(__FILE__)."/../_skel/header.php"); ?>

    <style>
        #list td, #list td{
            border: 1px solid #000000;
            padding: 2px;
        }
    </style>

    <h1>Lista piw użytkownika <?= $userEntity->username; ?></h1>
    <br />
    <table id="list">
        <tr>
            <?php foreach(Helper_PublicLevel::decodePublicLevel($userEntity->publicLevel) as $key => $value): ?>
                <?php if ($value==false) continue; ?>
                <th><?php echo $key;  ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach($beers as $beer): ?><?php
//var_dump($beer);die(); ?>
            <tr>
                <?php foreach(Helper_PublicLevel::decodePublicLevel($userEntity->publicLevel) as $key => $value): ?>
                    <?php if ($value==false) continue; ?>
                    <?php if ($key=="name"): ?>
                        <td><?php echo HTML::anchor($beer->beerLink, $beer->beerName) ; ?></td>
                    <?php continue; endif; ?>
                    <?php if ($key=="photo"): ?>
                        <td><?php $i=0; if ($beer->photosUrls!="") foreach(explode("\n", $beer->photosUrls) as $photo) { echo HTML::anchor($photo, "[".++$i."] "); } ?></td>
                        <?php continue; endif; ?>
                    <td><?php echo $beer->$key; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>