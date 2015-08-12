<?php $page_title="Witaj na MyBeerList!"; require(dirname(__FILE__)."/../_skel/header.php"); ?>

<script>
    $.ajax({
        dataType: "json",
        url: 'https://api.github.com/repos/danielskowronski/mybeerlist/stats/contributors',
        success: function(data){
            $("#commitCount").html(data[0]['total'])
        }
    });
</script>
    To jest commit #<span id="commitCount">...</span> na <a href="https://github.com/danielskowronski/mybeerlist">github.com/danielskowronski/mybeerlist</a>.


<?php require(dirname(__FILE__)."/../_skel/footer.php"); ?>