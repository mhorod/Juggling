var globalStyle;

//Stop space scrolling page
window.addEventListener('keydown', function(e) {
    if(e.keyCode == 32) {
      e.preventDefault();
    }
});


//Code added by Hichał
function update_entry_trick_desc(entryID)
{
	let request = new XMLHttpRequest();
    request.onreadystatechange = function()
    {
        if(request.readyState == 4 && request.status == 200)
        {
            let data = eval(request.responseText);
            //[{entry}, {date}]
            
            document.getElementsByClassName("post-title")[0].innerHTML = "Trik tygodnia " + data[1];
            document.getElementsByClassName("post-text")[0].innerHTML = data[0];
	    }
    }
    
    document.getElementsByClassName("post-title")[0].innerHTML = "Trik tygodnia loading..." ;
    document.getElementsByClassName("post-text")[0].innerHTML = "loading...";
	request.open("GET", "common/getEntryData.php?entryID="+entryID, true);
	request.send();	
}

function main()
{
    globalStyle = getComputedStyle(document.body);
    let suwajka = document.getElementById("suwajka");

    let menu = suwajka.childNodes[0];
    let count = suwajka.childNodes[1].data;

    suwajka.childNodes[1].remove();

    let divs = menu.childNodes;
    let frames = [];
    for(let i = 0; i < count; i++)
    {
        frames.push(new JugglerFrame(i, menu, true));
    }
    let activeElement = divs[count-1];
    let activeElementID = count-1;
    divs[count-1].classList.add("active");
    menu.style.left = -(frames.length-1)*divs[0].offsetWidth/2; 
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
            button.innerHTML = '<i class="fas fa-play"></i>';
        }else{
            button.innerHTML = '<i class="fas fa-pause"></i>';
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
    update_entry_trick_desc(count-1);
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

				update_entry_trick_desc(index); //Updates current description
				
            };
    });
	
};