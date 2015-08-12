<?php $page_title="Lista zaproszeń do znajomych".(($ignored) ? " ZIGNOROWANYCH" : ""); require(dirname(__FILE__)."/../_skel/header.php"); ?>

    <style>
        #list td, #list td{
            border: 1px solid #000000;
            padding: 2px;
        }
    </style>

<?php echo HTML::anchor('Friend/add', 'Dodaj znajomego'); ?><br/>
<?php echo HTML::anchor('Friend/list', 'Lista znajomych'); ?><br/>

<?php if ($ignored): ?>
<?php echo HTML::anchor('Friend/requests', 'Lista zaproszeń niezignorowanych'); ?><br/>
<?php else: ?>
<?php echo HTML::anchor('Friend/requests/ignored', 'Lista zaproszeń zignorowanych'); ?><br/>
<?php endif; ?>

    <br />
    <table id="list">
        <tr>
            <th>friend_avatar</th>
            <th>friend_username</th>
            <th>date_sent</th>
            <th>confirm</th>
            <th>ignore</th>
        </tr>

        <?php foreach($friendships as $friendship):
            $friend = Helper_User::userSummary($friendship->uid_a) ?>
            <tr>
                <td><?php echo HTML::image($friend->avatarUrl); ?></td>
                <td><?php echo HTML::chars($friend->username); ?></td>
                <td><?php echo HTML::chars($friendship->date_sent); ?></td>
                <td><?php echo HTML::anchor('Friend/confirm/'.$friendship->uid_a, 'Confirm'); ?></td>
                <td><?php echo HTML::anchor('Friend/ignore/'. $friendship->uid_a, 'Ignore'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>