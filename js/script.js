
$(document).ready(function() {
    $(".text-desc").toggle();
    $('select').selectpicker();

    console.log("ya");
    $("#btn-close-sidebar").click(function(){
        console.log("ya2");
        $(".text-desc").toggle();
        $("#body-pd").toggleClass('body-pd');
        $("#body-pd").toggleClass('body-pd-close');
    });

});