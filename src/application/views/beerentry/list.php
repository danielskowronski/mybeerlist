<?php $page_title="Moja lista piw"; require(dirname(__FILE__)."/../_skel/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="/files/table.css">

<?php echo HTML::anchor('BeerEntry/edit', 'Dodaj nowy'); ?><br/>
    <br />
    <table id="list" class="table table-striped">
        <tr>
            <th>Nazwa piwa</th>
            <th></th>
            <th></th>
        </tr>

        <?php foreach($beers as $beer): ?>
            <tr>
                <td><?php echo HTML::anchor('BeerEntry/show/'.$beer->id, HTML::chars($beer->beerName)); ?></td>
                <td><?php echo HTML::anchor('BeerEntry/edit/'.$beer->id, '<span class="glyphicon glyphicon-edit"></span> Edytuj'); ?></td>
                <td><?php echo HTML::anchor('BeerEntry/delete/'.$beer->id, '<span class="glyphicon glyphicon-remove"></span> Skasuj', array("onclick"=>"return confirm('Czy jesteś pewien?')")); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>