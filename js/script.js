
$(document).ready(function() {
    $(".text-desc").toggle();

    $("#btn-close-sidebar").click(function(){
        console.log("ya2");
        $(".text-desc").toggle();
        $("#body-pd").toggleClass('body-pd');
        $("#body-pd").toggleClass('body-pd-close');
    });

});