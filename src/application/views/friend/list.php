<?php require(dirname(__FILE__)."/../_skel/header.php"); ?>
<?php if (isset($message)): ?><h2><?php echo $message; ?></h2><?php endif;?>
    <style>
        #list td, #list td{
            border: 1px solid #000000;
            padding: 2px;
        }
    </style>

    <h1>Lista znajomych</h1>
<?php echo HTML::anchor('Friend/add', 'Dodaj znajomego'); ?><br/>
<?php echo HTML::anchor('Friend/requests', 'Zaproszenia oczekujące'); ?><br/>
    <br />
    <table id="list">
        <tr>
            <th>friend_avatar</th>
            <th>friend_username</th>
            <th>date_confirmed</th>
            <th>delete</th>
        </tr>

        <?php foreach($friendships as $friendship):
            $friend = Helper_User::userSummary($friendship->friend_uid) ?>
            <tr>
                <td><?php echo HTML::image($friend->avatarUrl); ?></td>
                <td><?php echo HTML::anchor('beerlist/'. $friend->username, HTML::chars($friend->username)); ?></td>
                <td><?php echo HTML::chars($friendship->date_confirmed); ?></td>
                <td><?php echo HTML::anchor('Friend/delete/'. $friendship->friend_uid, 'Delete'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>