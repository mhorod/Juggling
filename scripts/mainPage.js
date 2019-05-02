//TODO: Add docs...

var globalStyle;

window.addEventListener('keydown', function(e) {
  if(e.keyCode == 32) {
    e.preventDefault();
  }
});


//Code added by Hichał
function update_trick_desc(trickID)
{
	let request = new XMLHttpRequest();
    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            let data = request.responseText;
            document.getElementById("blog-entry").innerHTML = data;
	    }
    }
    //This link will likely change
	request.open("GET", "common/blogEntry.php?trickID="+trickID, true);
	request.send();	
}


function main()
{
    globalStyle = getComputedStyle(document.body);
    let suwajka = document.getElementById("suwajka");
    let menu = suwajka.childNodes[0];
    let divs = menu.childNodes;
    let frames = [];
    for(let i = 0; i <= 15; i++){
        frames.push(new JugglerFrame(i, menu));
    }
    let activeElement = divs[0];
    let activeElementID = 0;
    divs[0].classList.add("active");
    menu.style.left = (frames.length-1)*divs[0].offsetWidth/2; 
    function refreshDivs(){
        visibleTrickCount = Math.floor(Math.ceil(window.innerWidth/divs[0].offsetWidth)/2);
            for(let i = activeElementID-visibleTrickCount; i<=activeElementID+visibleTrickCount; i++){
                if(i>=0&&i<frames.length)
                    frames[i].visible = true;
            }
    }
    window.onresize = refreshDivs;
    refreshDivs();

    let button = document.getElementsByClassName("anim-button")[0];
    let slider = document.getElementsByClassName("anim-slider")[0];

    function togglePause(){
        frames[activeElementID].togglePause(Date.now());
        if(frames[activeElementID].paused){
            button.value = "▶";
        }else{
            button.value = "▮▮";
        }
    }
    function updateAnimSpeed(){
        frames[activeElementID].changeAnimSpeed(slider.value/1000.0, Date.now());
    }
    button.onclick = togglePause;
     document.body.onkeyup = function(e){
        if(e.keyCode == 32){
           togglePause();
        }
    }
    slider.oninput = updateAnimSpeed;
    update_trick_desc(0);
    divs.forEach(
        function(currentValue, index){
            currentValue.onclick = function()
			{
                activeElement.classList.remove("active");
                this.classList.add("active");
                activeElement = this;
                for(let i = activeElementID-visibleTrickCount; i<=activeElementID+visibleTrickCount; i++){
                    if(i>=0&&i<frames.length)
                        frames[i].visible = false;
                }
                if(frames[activeElementID].paused){
                    togglePause();
                }
                slider.value = 500;
                updateAnimSpeed();
                activeElementID = index;
                refreshDivs();
                menu.style.left = (frames.length-1)*divs[0].offsetWidth/2-index*divs[0].offsetWidth;

				update_trick_desc(index); //Updates current description
				
            };
    });
	
};