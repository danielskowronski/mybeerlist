<h1>List beers drank</h1>
<?php echo HTML::anchor('BeerEntry/edit', 'Create new entry'); ?><br/>
    <br />
    <table id="list">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>url</th>
        </tr>

        <?php foreach($beers as $beer): ?>
            <tr>
                <td><?php echo HTML::chars($beer->id); ?></td>
                <td><?php echo HTML::chars($beer->beerName); ?></td>
                <td><a href="<?php echo HTML::chars($beer->beerLink); ?>"><?php echo HTML::chars($beer->beerLink); ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>