function showPhoto(url){
    $("#photoCanvas").css("display","table-cell");
    $("#photoCanvas").html("Wciśnij Escape lub kliknij gdziekolwiek by zamknąć.<br /><img id='photoCanvasImg' src='"+url+"' />");
    $("#siteGrayout").css("display","block");
}
function hidePhoto(){
    $("#photoCanvas").css("display","none");
    $("#siteGrayout").css("display","none");
}

$(document).keydown(function(e) {
    if (e.keyCode == 27) {
        hidePhoto();
    }
});
$(document).ready(function(){
    $('.clicker').click(function(event) {
        event.stopPropagation();
    });
    $('html').click(function() {
        hidePhoto();
    });
    $("body").append( "<div id='siteGrayout'></div>" );
});