<h1>List beers drinken</h1>
<?php echo HTML::anchor('page/edit', 'Create page'); ?><br/>
    <br />
    <table id="list">
        <tr><th>id</th><th>name</th></tr>

        <?php foreach($beers as $beer): ?>
            <tr>
                <td><?php echo HTML::chars($beer->id); ?></td>
                <td><?php echo HTML::chars($beer->beerName); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>