<?php $page_title="Moja lista piw"; require(dirname(__FILE__)."/../_skel/header.php"); ?>
    <link rel="stylesheet" type="text/css" href="/files/table.css">

<?php echo HTML::anchor('BeerEntry/edit', 'Dodaj nowy zapis'); ?><br/>
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
    <br />
    <h2>Lista życzeń</h2>
<?php echo HTML::anchor('WantedBeerEntry/edit', 'Dodaj nowe do listy życzeń'); ?><br/>
    <table id="list" class="table table-striped">
        <tr>
            <th>Nazwa piwa</th>
            <th>Notatki</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>

        <?php foreach($wantedbeers as $wantedbeer): ?>
            <tr>
                <td><?php echo HTML::anchor($wantedbeer->beerLink, HTML::chars($wantedbeer->beerName)); ?></td>
                <td><em><?php echo HTML::chars($wantedbeer->notes); ?></em></td>
                <td><?php echo HTML::anchor('WantedBeerEntry/convert/'.$wantedbeer->id, '<span class="glyphicon glyphicon-glass"></span> Wypiłem je', array("onclick"=>"return confirm('Czy jesteś pewien?\\nTen rekord zostanie skasowany, a Ty zostaniesz przeniesiony do widoku edycji nowego wpisu piwa wypitego, jednak póki go nie zapiszesz - nie będzie istniał.')")); ?></td>
                <td><?php echo HTML::anchor('WantedBeerEntry/edit/'.$wantedbeer->id, '<span class="glyphicon glyphicon-edit"></span> Edytuj'); ?></td>
                <td><?php echo HTML::anchor('WantedBeerEntry/delete/'.$wantedbeer->id, '<span class="glyphicon glyphicon-remove"></span> Skasuj', array("onclick"=>"return confirm('Czy jesteś pewien?')")); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>