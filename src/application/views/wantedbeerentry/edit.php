<?php $page_title="Edytuj wpis - lista życzeń"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<style>
    #beerSearchResults{
        padding: 10px;
    }
    .picrel{
        max-height: 75px;
    }
</style>
<script src="/files/beerselector.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<?php echo Form::open('WantedBeerEntry/edit/' . $wantedbeerentry->id); ?>

<?php echo Form::label('beerName', "Nazwa piwa"); ?>
<?php echo Form::input('beerName', $wantedbeerentry->beerName, array('size'=>'32', 'id'=>'beerQueryInput')); ?>
<input type="button" onclick="queryBeers()" value="znajdź w bazie ocen-piwo.pl" /><br/>
<div id="beerSearchResults"></div>

<?php echo Form::input('beerLink', $wantedbeerentry->beerLink, array('id'=>'beerUrl', 'type'=>'hidden')); ?>

<?php echo Form::label('notes', "Notatki"); ?><br />
<?php echo Form::textarea('notes', $wantedbeerentry->notes, array('columns'=>'32', 'rows'=>'5')); ?><br />

<?php echo Form::submit('save', 'Zapisz'); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>