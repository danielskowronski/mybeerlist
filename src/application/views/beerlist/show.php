<?php $page_title="Lista piw użytkownika ".$userEntity->username;  require(dirname(__FILE__)."/../_skel/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="/files/table.css">

    <?= HTML::image(Helper_User::gravatarUrl($userEntity)); ?>

    <link rel="stylesheet" type="text/css" href="/files/photoShower/style.css">
    <script src="/files/photoShower/script.js"></script>
    <div id="photoCanvas"></div>

    <br />
    <table id="list" class="table table-striped">
        <tr>
            <?php foreach(Helper_PublicLevel::decodePublicLevel(Auth::instance()->logged_in() && Helper_User::areFriends(Auth::instance()->get_user()->id, $userEntity->id) ? Helper_PublicLevel::$maxLevel : $userEntity->publicLevel) as $key => $value): ?>
                <?php if ($value==false) continue; ?>
                <th><?php echo Helper_PublicLevel::translateRawPublicityName($key);  ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach($beers as $beer): ?>
            <tr>
                <?php foreach(Helper_PublicLevel::decodePublicLevel(Auth::instance()->logged_in() && Helper_User::areFriends(Auth::instance()->get_user()->id, $userEntity->id) ? Helper_PublicLevel::$maxLevel : $userEntity->publicLevel) as $key => $value): ?>
                    <?php if ($value==false) continue; ?>
                    <?php if ($key=="name"): ?>
                        <td><?php if ($beer->beerLink=="") echo $beer->beerName; else echo HTML::anchor($beer->beerLink, $beer->beerName) ; ?></td>
                    <?php continue; endif; ?>
                    <?php if ($key=="photo"): ?>
                        <td><?php $i=0; if ($beer->photosUrls!="") foreach(explode(" ", $beer->photosUrls) as $photo) { if ($photo=="") continue; echo "<a class='clicker' onClick='showPhoto(\"$photo\")'>[".++$i."]</a>"; } ?></td>
                        <?php continue; endif; ?>
                    <td><?php echo $beer->$key; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>Lista życzeń</h2>
    <table id="list" class="table table-striped">
        <tr>
            <?php foreach(Helper_PublicLevelOfWanted::decodePublicLevel(Auth::instance()->logged_in() && Helper_User::areFriends(Auth::instance()->get_user()->id, $userEntity->id) ? Helper_PublicLevelOfWanted::$maxLevel : $userEntity->publicLevelOfWanted) as $key => $value): ?>
                <?php if ($value==false) continue; ?>
                <th><?php echo Helper_PublicLevelOfWanted::translateRawPublicityName($key);  ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach($wantedbeers as $wantedbeer): ?>
            <tr>
                <?php foreach(Helper_PublicLevelOfWanted::decodePublicLevel(Auth::instance()->logged_in() && Helper_User::areFriends(Auth::instance()->get_user()->id, $userEntity->id) ? Helper_PublicLevelOfWanted::$maxLevel : $userEntity->publicLevelOfWanted) as $key => $value): ?>
                    <?php if ($value==false) continue; ?>
                    <?php if ($key=="name"): ?>
                        <td><?php if ($wantedbeer->beerLink=="") echo $wantedbeer->beerName; else echo HTML::anchor($wantedbeer->beerLink, $wantedbeer->beerName) ; ?></td>
                        <?php continue; endif; ?>
                    <td><?php echo $wantedbeer->$key; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>