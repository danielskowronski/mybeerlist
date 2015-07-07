<h1>Edit beer entry</h1>

<style>
    #beerSearchResults{
        border: 1px solid black;
        margin: 10px;
    }
</style>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
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

<?php echo Form::open('BeerEntry/edit/' . $beerentry->id); ?>

<?php echo Form::label('beerName', "Beer name"); ?>
<?php echo Form::input('beerName', $beerentry->beerName, array('size'=>'64', 'id'=>'beerQueryInput')); ?>
<input type="button" onclick="queryBeers()" value="find beer in ocen-piwo.pl database" /><br/>
<div id="beerSearchResults"></div>

<?php echo Form::input('beerLink', $beerentry->beerLink, array('size'=>'64', 'id'=>'beerUrl', 'type'=>'hidden')); ?>


<br/>
<?php echo Form::submit('save', 'Save'); ?><br/>

<?php echo Form::close(); ?>