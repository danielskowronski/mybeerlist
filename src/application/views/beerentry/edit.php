<?php require(dirname(__FILE__)."/../_skel/header.php"); ?>

<style>
    #beerSearchResults{
        padding: 10px;
    }
</style>
<script>
    const beerListProviderURL = "/BeerDataProviderSearcher";

    function queryBeers() {
        var beerQuery=$("#beerQueryInput").val();
        $.get(
            beerListProviderURL+"?name="+beerQuery,
            function (data) {
                var response = JSON.parse(data);
                $("#beerSearchResults").html(""); //clear old results
                response.forEach(function(elem){
                    $("#beerSearchResults").append(
                        "<li><a onClick='selectBeer(\""+elem["url"]+"\",\""+elem["name"]+"\")'>"+elem["name"]+"</a></li>"
                    );
                });
            }
        );
    }
    function selectBeer(url, name){
        $("#beerQueryInput").val(name);
        $("#beerUrl").val(url);
        $("#beerSearchResults").html(""); //clear old results
    }
</script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
    $(function() {
        $( "#datepicker" ).datepicker({
            dateFormat: "yy-mm-dd" // contrary to appearances yy means 2015 not 15
        });
    });
</script>

<h1>Edytuj wpis</h1>

<?php echo Form::open('BeerEntry/edit/' . $beerentry->id); ?>

<?php echo Form::label('beerName', "Nazwa piwa"); ?>
<?php echo Form::input('beerName', $beerentry->beerName, array('size'=>'32', 'id'=>'beerQueryInput')); ?>
<input type="button" onclick="queryBeers()" value="znajdź w bazie ocen-piwo.pl" /><br/>
<div id="beerSearchResults"></div>

<?php echo Form::input('beerLink', $beerentry->beerLink, array('id'=>'beerUrl', 'type'=>'hidden')); ?>

<br/>

<?php echo Form::label('date', "Data"); ?>
<?php echo Form::input('date', $beerentry->date, array('id'=>'datepicker')); ?><br />

<?php echo Form::label('location', "Lokal"); ?>
<?php echo Form::input('location', $beerentry->location, array('size'=>'32')); ?><br />

<?php echo Form::label('companions', "Towarzystwo"); ?>
<?php echo Form::input('companions', $beerentry->companions, array('size'=>'32')); ?><br />

<?php echo Form::label('rating', "Ocena (0-10, 0 = Kompania Piwowarska xD)"); ?>
<?php echo Form::input('rating', $beerentry->rating, array('type'=>'number', 'min'=>'0', 'max'=>'10')); ?><br />

<?php echo Form::label('photosUrls', "URLe pic related"); ?><br />
<?php echo Form::textarea('photosUrls', $beerentry->photosUrls, array('columns'=>'32', 'rows'=>'5')); ?><br />

<?php echo Form::label('notes', "Notatki"); ?><br />
<?php echo Form::textarea('notes', $beerentry->notes, array('columns'=>'32', 'rows'=>'5')); ?><br />

<?php echo Form::submit('save', 'Zapisz'); ?><br/>

<?php echo Form::close(); ?>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>