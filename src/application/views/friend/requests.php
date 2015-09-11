<?php $page_title="Lista zaproszeń do znajomych".(($ignored) ? " ZIGNOROWANYCH" : ""); require(dirname(__FILE__)."/../_skel/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="/files/table.css">
    <link rel="stylesheet" type="text/css" href="/files/avatar.css">

<?php echo HTML::anchor('Friend/add', 'Dodaj znajomego'); ?><br/>
<?php echo HTML::anchor('Friend/list', 'Lista znajomych'); ?><br/>

<?php if ($ignored): ?>
<?php echo HTML::anchor('Friend/requests', 'Lista zaproszeń niezignorowanych'); ?><br/>
<?php else: ?>
<?php echo HTML::anchor('Friend/requests/ignored', 'Lista zaproszeń zignorowanych'); ?><br/>
<?php endif; ?>

    <br />
    <table id="list" class="table table-striped">
        <tr>
            <th></th>
            <th>Nazwa użytkownika</th>
            <th>Data wysłania</th>
            <th></th>
            <th></th>
        </tr>

        <?php foreach($friendships as $friendship):
            $friend = Helper_User::userSummary($friendship->uid_a) ?>
            <tr>
                <td><?php echo HTML::image(Helper_User::gravatarUrl($friend), array("class"=>"avatarMini")); ?></td>
                <td><?php echo HTML::chars($friend->username); ?></td>
                <td><?php echo HTML::chars($friendship->date_sent); ?></td>
                <td><?php echo HTML::anchor('Friend/confirm/'.$friendship->uid_a, '<span class="glyphicon glyphicon-ok"></span> Potwierdź', array("onclick"=>"return confirm('Czy jesteś pewien?')")); ?></td>
                <td><?php echo HTML::anchor('Friend/ignore/'. $friendship->uid_a, '<span class="glyphicon glyphicon-remove"></span> Skasuj', array("onclick"=>"return confirm('Czy jesteś pewien?')")); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>