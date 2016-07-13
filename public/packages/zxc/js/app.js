$(function () { 
    //csrf
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    //mask
    $("#loader").delay(500).fadeOut(300);
    $(".mask").delay(800).fadeOut(300);

})
