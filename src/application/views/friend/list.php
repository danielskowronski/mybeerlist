<?php $page_title="Lista znajomych"; require(dirname(__FILE__)."/../_skel/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="/files/table.css">

<?php echo HTML::anchor('Friend/add', 'Dodaj znajomego'); ?><br/>
<?php echo HTML::anchor('Friend/requests', 'Zaproszenia oczekujące'); ?><br/>
    <br />
    <table id="list" class="table table-striped">
        <tr>
            <th></th>
            <th>Użytkownik</th>
            <th>Data zawarcia znajomości</th>
            <th></th>
        </tr>

        <?php foreach($friendships as $friendship):
            $friend = Helper_User::userSummary($friendship->friend_uid) ?>
            <tr>
                <td><?php echo HTML::image($friend->avatarUrl); ?></td>
                <td><?php echo HTML::anchor('beerlist/'. $friend->username, HTML::chars($friend->username)); ?></td>
                <td><?php echo HTML::chars($friendship->date_confirmed); ?></td>
                <td><?php echo HTML::anchor('Friend/delete/'. $friendship->friend_uid, '<span class="glyphicon glyphicon-remove"></span> Usuń znajomego', array("onclick"=>"return confirm('Czy jesteś pewien?')")); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>