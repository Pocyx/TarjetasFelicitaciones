
$(document).ready(function () {
    
    

    var colores = ["black", "blue", "green", "yellow"];

    var posVertical = [334, 341, 344, 340, 333, 271, 275, 279, 276, 217, 216, 228, 216, 164, 171, 165, 108, 106, 105];
    var posHorizontal = [47, 117, 191, 269, 345, 74, 157, 242, 330, 93, 167, 257, 307, 113, 198, 286, 131, 190, 245];

    var borrar = false;

    $("#adornar2").click(function () {
        clearInterval(intervalo);
        if (borrar) {
            eliminar();
            borrar = false;
        }

        $("#arbol").css({
            "left": 0,
            "animation-play-state": "paused"

        });
        adornar();
    });
    var intervalo
    $(document).ready(function () {
        $('#mover').click(function () {
            clearInterval(intervalo);
            borrar = true;
            sacudir();
            $("#arbol").css({
                "animation-play-state": "running"
            });
            setTimeout(function () {
                $("#arbol").css({
                    "animation-play-state": "paused"
                });
            }, 500);
        });
    });

    $(document).ready(function () {
        $('#adornar').click(function () {
            if (borrar) {
                eliminar();
                borrar = false;
            }
            intervalo = setInterval(adornar, 500);
        });
    });

    function sacudir() {
        for (var e = 0; e < 500; e++) {
            $("#bola" + e).animate({top: 500}, 1000, 'linear');
            //$("#bola" + e).remove();

        }
        // setTimeout (eliminar(), 500);
        // setTimeout (eliminar(), 50000000); 

        i = 0;

    }

    function eliminar() {
        for (var e = 0; e < 200; e++) {
            //$("#bola" + e).animate({top: 500}, 1000, 'linear');
            // $("#bola" + e).delay("slow").fadeIn();
            $("#bola" + e).remove();

        }
    }


    var i = 0;
    function adornar() {
        i++;
        var imagen = Math.floor(Math.random() * 8);
        var pos = Math.floor(Math.random() * 19);
        var bola = $("<div>");
        bola.addClass("bolita");
        bola.attr('id', 'bola' + i);
        bola.css({
            "background-image": "url(imagen/" + imagen + ".png)",
            "top": -30,
            "left": posHorizontal[pos]
        });
        $("#juego").append(bola);
        $("#bola" + i).animate({top: posVertical[pos]}, 1000, 'linear');
    }






});
var soltado = false;
function elementoSoltado(event, ui)
{
    soltado = true;
    // var id = ui.draggable.attr("id");
    //$("#log").text("La imagen con id [" + id + "] ha sido soltada y aceptada");
}


function strella() {
    var ar1 = document.createElement("div");
    var ar12 = document.createElement("div");
    var ar13 = document.createElement("div");
    ar1.setAttribute("id", "arrastrar1");
    ar12.setAttribute("id", "arrastrar2");
    ar13.setAttribute("id", "arrastrar3");
    document.getElementById("contenedor").appendChild(ar1);
    document.getElementById("contenedor").appendChild(ar12);
    document.getElementById("contenedor").appendChild(ar13);
    $("#arrastrar1").draggable();
    $("#arrastrar2").draggable();
    $("#arrastrar3").draggable();

}
function titulo(){
    $(".cabeza").animate({justifycontent: 'baseline'}, 1000, 'linear');
    $(".cabeza").animate({justifycontent: 'center'}, 1000, 'linear');
}
