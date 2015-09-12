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