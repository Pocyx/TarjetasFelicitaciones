function titulo() {
    $(".cabeza").css("text-align","center");
    $(".cabeza").animate({opacity: 0}, 1000, 'linear');
    $(".cabeza").animate({opacity: 1}, 1000, 'linear');
}

$(document).ready(function () {
    $("#capaoculta").toggle();
    $("#registro").on("click", function () {
        $("#formLogin").hide();
        $("#registro").hide();
        $("#capaoculta").toggle();
    });
});