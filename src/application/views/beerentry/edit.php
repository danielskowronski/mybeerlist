<?php $page_title="Edytuj wpis"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<style>
    #beerSearchResults{
        padding: 10px;
    }
    .picrel{
        max-height: 75px;
    }
</style>
<script>
    const beerListProviderURL = "/BeerDataProviderSearcher";

    function queryBeers() {
        var beerQuery=$("#beerQueryInput").val();
        $("#beerSearchResults").html("<img src='/files/loader.gif' />");
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
            dateFormat: "yy-mm-dd" // contrary to appearance yy means 2015 not 15
        });
    });
</script>

<script>
    function deletePhoto(url)
    {
        $.get("/photo/delete/"+url.substring(8), function(){});
        $("#photosUrls").val($("#photosUrls").val().replace(url,""))
        $($($("img[src='"+url+"']")[0]).parent()).remove()
    }

    // addPhoto
    $( document ).ready(function() {
        var form = document.getElementById('file-form');
        var fileSelect = document.getElementById('file-select');
        var uploadButton = document.getElementById('upload-button');
        form.onsubmit = function(event) {
            event.preventDefault();
            uploadButton.innerHTML = 'Przesyłanie...';
            var files = fileSelect.files;
            var formData = new FormData();
            var file = files[0];
            if (!file.type.match('image.*')) {
                alert('To nie jest obrazek!');
                uploadButton.innerHTML = '<span class="glyphicon glyphicon-cloud-upload"></span>Dodaj zdjęcie';
                return;
            }
            formData.append('photo', file, file.name);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/photo/upload', true);
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText!="ERROR") {
                    $("#photosUrls").val($("#photosUrls").val()+" /photos/"+xhr.responseText)
                    $("#photos").html($("#photos").html()+"<span><img class='picrel clicker' src='/photos/"+xhr.responseText+"'><a onClick='deletePhoto(\"/photos/"+xhr.responseText+"\")'><span class=\"glyphicon glyphicon-remove\"></span> Skasuj</a><br /></span>")
                    uploadButton.innerHTML = '<span class="glyphicon glyphicon-cloud-upload"></span>Dodaj zdjęcie';
                } else {
                    alert('Wystąpił błąd');
                }
            };
            xhr.send(formData);
        }
    });
</script>

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

<?php echo Form::hidden('photosUrls', $beerentry->photosUrls, array("id"=>"photosUrls")); ?>

<?php echo Form::label('notes', "Notatki"); ?><br />
<?php echo Form::textarea('notes', $beerentry->notes, array('columns'=>'32', 'rows'=>'5')); ?><br />

<?php echo Form::submit('save', 'Zapisz'); ?><br/>

<?php echo Form::close(); ?>


<div id="photos">
    <?php
    $picrel = preg_split("/\s/", $beerentry->photosUrls);
    if (count($picrel)!=0)
    {
        foreach ($picrel as $photo) {
            if ($photo=="") continue;
            echo "<span><img onClick='javascript:showPhoto(\"$photo\")' src='$photo' class='picrel clicker'/><a onClick='deletePhoto(\"$photo\")'><span class=\"glyphicon glyphicon-remove\"></span>Skasuj</a><br /></span>";
        }
    }
    ?></div>
<br />
<form id="file-form" action="/photo/upload" method="POST">
    <input type="file" id="file-select" name="photo" style="display: inline"/>
    <button type="submit" id="upload-button"><span class="glyphicon glyphicon-cloud-upload"></span>Dodaj zdjęcie</button>
</form>

<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>