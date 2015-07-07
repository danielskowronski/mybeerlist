<?php require(dirname(__FILE__)."/../_skel/header.php"); ?>

<style>
    #list td, #list td{
        border: 1px solid #000000;
        padding: 2px;
    }
</style>

<h1>Moja lista piw</h1>
<?php echo HTML::anchor('BeerEntry/edit', 'Dodaj nowy'); ?><br/>
    <br />
    <table id="list">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>edit</th>
            <th>delete</th>
        </tr>

        <?php foreach($beers as $beer): ?>
            <tr>
                <td><?php echo HTML::chars($beer->id); ?></td>
                <td><?php echo HTML::anchor('BeerEntry/show/'.$beer->id, HTML::chars($beer->beerName)); ?></td>
                <td><?php echo HTML::anchor('BeerEntry/edit/'.$beer->id, 'Edytuj wpis'); ?></td>
                <td><?php echo HTML::anchor('BeerEntry/delete/'.$beer->id, 'Skasuj wpis'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>