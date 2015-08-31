function showPhoto(url){
    $("#photoCanvas").css("display","block");
    $("#photoCanvas").html("Wciśnij Escape lub kliknij gdziekolwiek by zamknąć.<br /><img id='photoCanvasImg' src="+url+" />");
    //console.log("show")
}
function hidePhoto(){
    $("#photoCanvas").css("display","none");
    //console.log("hide")
}

$(document).keydown(function(e) {
    if (e.keyCode == 27) {
        hidePhoto();
    }
});
$(document).ready(function(){
    $('.clicker').click(function(event) {
        event.stopPropagation();
        //console.log("cancel")
    });
    $('html').click(function() {
        hidePhoto();
    });
});