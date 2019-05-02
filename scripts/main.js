var globalStyle;

//PLZ COMMENT THAT SHIT
//JUST IN CASE
window.addEventListener('keydown', function(e) {
  if(e.keyCode == 32) {
    e.preventDefault();
  }
});

function main()
{
    globalStyle = getComputedStyle(document.body);

    var canvas = document.getElementsByClassName("mainCanvas")[0];
    var ctx = canvas.getContext("2d");
    
    var canvasWidth = globalStyle.getPropertyValue('--trick-width');
    var canvasHeight = globalStyle.getPropertyValue('--trick-height');
    
    canvas.width = canvasWidth.substr(0, canvasWidth.length - 2);
    canvas.height = canvasHeight.substr(0, canvasHeight.length - 2);
    
    let slider = document.getElementsByClassName("anim-slider")[0];
    let button = document.getElementsByClassName("anim-button")[0];

    let data = eval(document.getElementById("trickData").innerHTML);
    let time = Date.now();
    let juggler = new Juggler(data, time);
    document.body.onkeyup = function(e){
        if(e.keyCode == 32){
            juggler.togglePause(Date.now());
            if(juggler.paused){
                button.value = "▶";
            }else{
                button.value = "▮▮";
            }
        }
    }
    button.onclick = function(e){
        juggler.togglePause(Date.now());
        if(juggler.paused){
            button.value = "▶";
        }else{
            button.value = "▮▮";
        }
    };

    juggler.changeAnimSpeed(slider.value/1000.0, Date.now());
    slider.oninput = function(e){
        juggler.changeAnimSpeed(slider.value/1000.0, Date.now());
    }
    setInterval(function(){
        let time = Date.now();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        juggler.update(time);
        juggler.draw(ctx);

    }, 10);
};
