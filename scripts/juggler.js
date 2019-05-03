/*

Make at least some documentation about that code...
There are fucking 500 lines and we don't want to mess up.
(:

*/

const g = 10;
function JugglerFrame(trickID, div, fromEntryID){
    globalStyle = getComputedStyle(document.body);
    this.visible = false;
    this.paused = false;
    this.juggler = new EmptyJuggler(trickID);
    this.frame = document.createElement("DIV");
    this.animWrapper = document.createElement("DIV");
    this.canvas = document.createElement("CANVAS");
    this.descWrapper = document.createElement("DIV");

    this.trickName = document.createElement("SPAN");
    this.trickDifficulty = document.createElement("SPAN");
    this.trickSiteswap = document.createElement("SPAN");

    this.frame.setAttribute("class", "trick-wrapper");
    this.animWrapper.setAttribute("class" , "animation-wrapper");
    this.canvas.setAttribute("class" , "mainCanvas");
    this.descWrapper.setAttribute("class","trick-desc");
    this.trickName.setAttribute("class", "desc-item");
    this.trickDifficulty.setAttribute("class", "desc-item");
    this.trickSiteswap.setAttribute("class", "desc-item");
    this.trickName.innerHTML = "loading...";
    this.trickDifficulty.innerHTML = "loading...";
    this.trickSiteswap.innerHTML = "loading...";

    this.animWrapper.appendChild(this.canvas);

    this.descWrapper.appendChild(this.trickName);
    this.descWrapper.appendChild(this.trickDifficulty);
    this.descWrapper.appendChild(this.trickSiteswap);

    this.frame.appendChild(this.animWrapper);
    this.frame.appendChild(this.descWrapper);

    div.appendChild(this.frame);

    let canvasWidth = globalStyle.getPropertyValue('--trick-width');
    let canvasHeight = globalStyle.getPropertyValue('--trick-height');

    this.canvas.width = 300;
    this.canvas.height = 375;

    this.ctx = this.canvas.getContext("2d");
    let instance = this;
    this.interval = setInterval(function(){
            instance.juggler.update(Date.now());
        if(instance.visible){
             instance.ctx.clearRect(0, 0, instance.canvas.width, instance.canvas.height);
            instance.juggler.draw(instance.ctx);
        }
    }, 20);
    this.togglePause = function(time){
        this.juggler.togglePause(time); 
        this.paused = this.juggler.paused;
    };
    this.changeAnimSpeed = this.juggler.changeAnimSpeed;
    let request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let data = eval(request.responseText);
            instance.trickName.innerHTML = data[0];
            instance.trickDifficulty.innerHTML = "Difficulty: "+data[1];
            instance.trickSiteswap.innerHTML = "Siteswap: "+data[2];
            instance.juggler.updateData(data[4]);
        }
    }
    if(fromEntryID)
        request.open("GET", "common/getEntryData.php?entryID="+trickID+"&trickOnly=true", true);
    else
        request.open("GET", "common/getTrickData.php?trickID="+trickID, true);
    request.send();
}
function EmptyJuggler(trickID){
    this.data = undefined;
    this.juggler = undefined;
    this.paused = true;
    this.animSpeed = 0.5;
}
EmptyJuggler.prototype.draw = function(ctx){
    if(this.juggler !== undefined)
            this.juggler.draw(ctx);
}
EmptyJuggler.prototype.changeAnimSpeed = function(speed, time){
        if(this.juggler !== undefined)
            this.juggler.changeAnimSpeed(speed, time);
        else
            this.animSpeed = speed;
}
EmptyJuggler.prototype.togglePause = function(time){
        if(this.juggler !== undefined)
            this.juggler.togglePause(time);
        this.paused = this.juggler.paused;
}
EmptyJuggler.prototype.updateData = function(data){
        this.data = data;
}
EmptyJuggler.prototype.update = function(time){
        if(this.juggler !== undefined){
            this.juggler.update(time);
        }else if(this.data !== undefined&&this.juggler===undefined){
            this.juggler = new Juggler(this.data, time);
            if(this.animSpeed !== undefined){
                this.juggler.changeAnimSpeed(this.animSpeed, time);
            }
            this.paused = this.juggler.paused;
        }
}
function AjaxJuggler(trickID){
    let request = new XMLHttpRequest();
    this.data = undefined;
    this.juggler = undefined;
    this.paused = true;
    let instance = this;
    this.animSpeed = undefined;
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            instance.data = eval(request.responseText)[4];
        }
    }
    request.open("GET", "common/getTrickData.php?trickID="+trickID, true);
    request.send();
    this.draw = function(ctx){
        if(this.juggler !== undefined)
            this.juggler.draw(ctx);
    }
    this.changeAnimSpeed = function(speed, time){
        if(this.juggler !== undefined)
            this.juggler.changeAnimSpeed(speed, time);
        else
            this.animSpeed = speed;
    }
    this.togglePause = function(time){
        if(this.juggler !== undefined)
            this.juggler.togglePause(time);
        this.paused = this.juggler.paused;
    }

    this.update = function(time){
        if(this.juggler !== undefined){
            this.juggler.update(time);
        }else if(this.data !== undefined&&this.juggler===undefined){
            this.juggler = new Juggler(this.data, time);
            if(this.animSpeed !== undefined){
                this.juggler.changeAnimSpeed(this.animSpeed, time);
            }
            this.paused = this.juggler.paused;
        }
    }
}
function Juggler(data, time){
    this.startTime = time;
    this.pauseTime = 0;
    this.animationSpeed = 1;
    this.flareLength = 0;
    this.paused = false;
    let throws = new Array();
    let ballPaths = new Array();
    this.ballFlares = new Array();
    for(let i = 0; i<data[0].length; i++)
    {
        if(data[0][i][0] == "t")
            throws.push(new Parabola(data[0][i][1], data[0][i][2], data[0][i][3], data[0][i][4], data[0][i][5], data[0][i][6]));
        if(data[0][i][0] == "w")
            throws.push(new Point(data[0][i][1], data[0][i][2], data[0][i][3], data[0][i][4]));
    }
    for(let i = 0; i<data[1].length; i++)
    {
        ballPaths.push(new Path(throws, data[1][i].slice(0,data[1][i].length-1), data[1][i][data[1][i].length-1], true));
    }
    let lhandPath = new Path(throws, data[2][0].slice(0, data[2][0].length-1), data[2][0][data[2][0].length-1], false);
    let rhandPath = new Path(throws, data[2][1].slice(0, data[2][1].length-1), data[2][1][data[2][1].length-1], false);
    this.rhand = new PathWalker(rhandPath, data[4][1]);
    this.lhand = new PathWalker(lhandPath, data[4][0]);


    this.balls = new Array();
    for(let i = 0; i<data[3].length; i++){
        this.balls.push(new PathWalker(ballPaths[data[3][i][0]],data[3][i][1]));
        this.ballFlares.push(new Array());
    }
};
Juggler.prototype.togglePause = function(time){
    if(this.paused){
        this.paused = false;
        this.startTime += time-this.pauseTime;
    }else{
        this.paused = true;
        this.pauseTime = time;
    }
}
Juggler.prototype.changeAnimSpeed = function(speed, time){
    this.startTime = time + (this.startTime - time)*this.animationSpeed/speed;
    this.pauseTime = time + (this.pauseTime - time)*this.animationSpeed/speed;
    this.animationSpeed = speed;
}
Juggler.prototype.draw = function(ctx){
    this.drawBody(ctx);
    this.drawArms(ctx);
    this.drawBalls(ctx);
};
Juggler.prototype.drawArms = function(ctx){
    let pos1 = this.rhand.pos;
    let pos2 = this.lhand.pos;
    let armsColor = globalStyle.getPropertyValue("--arms-color");
    let armsThickness = globalStyle.getPropertyValue("--arms-thickness");

    let l1 = getCoords(ctx, {x: -0.5, y: 0.1});
    l1.x-=4;
    let l2 = getCoords(ctx, {x: -0.7-(-0.7-pos1.x)/2, y: -0.3});
    let l3 = getCoords(ctx, pos1);
    ctx.beginPath();

    ctx.strokeStyle = armsColor;
    ctx.lineWidth = armsThickness;

    ctx.moveTo(l1.x, l1.y);
    ctx.lineTo(l2.x, l2.y);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(l2.x, l2.y);
    ctx.lineTo(l3.x, l3.y);
    ctx.stroke();

    let r1 = getCoords(ctx, {x: 0.5, y: 0.1});
    r1.x+=4;
    let r2 = getCoords(ctx, {x: 0.7-(0.7-pos2.x)/2, y: -0.3});
    let r3 = getCoords(ctx, pos2);
    ctx.beginPath();
    ctx.strokeStyle = armsColor;
    ctx.lineWidth = armsThickness;
    ctx.moveTo(r1.x, r1.y);
    ctx.lineTo(r2.x, r2.y);
    ctx.stroke();
    ctx.moveTo(r2.x, r2.y);
    ctx.lineTo(r3.x, r3.y);
    ctx.stroke();
}

Juggler.prototype.drawBody = function(ctx){
    let bodyBorderColor = globalStyle.getPropertyValue("--body-border-color");
    let bodyBorderThickness = globalStyle.getPropertyValue("--body-border-thickness");
    let bodyFillColor = globalStyle.getPropertyValue("--body-fill-color");

    let pos1 = getCoords(ctx, {x: -0.3, y: -0.7});
    let pos2 = getCoords(ctx, {x: 0.3, y: -0.7});
    let pos3 = getCoords(ctx, {x: 0.5, y: 0.1});
    let pos4 = getCoords(ctx, {x: -0.5, y: 0.1});

    ctx.beginPath();
    ctx.strokeStyle = bodyBorderColor;
    ctx.lineWidth = bodyBorderThickness;
    ctx.fillStyle = bodyFillColor;
    ctx.moveTo(pos1.x, pos1.y);
    ctx.lineTo(pos2.x, pos2.y);
    ctx.lineTo(pos3.x, pos3.y);
    ctx.lineTo(pos4.x, pos4.y);
    ctx.closePath();
    ctx.stroke();
    ctx.fill();

    let headPos = getCoords(ctx, {x: 0, y: 0.4});
    let headWidth = getLength(ctx, 0.2);
    let headHeight = getLength(ctx, 0.25);
    ctx.beginPath();
    ctx.ellipse(headPos.x, headPos.y, headWidth, headHeight, 0, 2*Math.PI, false);
    ctx.stroke();
    ctx.fill();
}
Juggler.prototype.drawBalls = function(ctx){
    let ballOutlineColor = globalStyle.getPropertyValue("--ball-outline-color");
    let ballOutlineThickness = globalStyle.getPropertyValue("--ball-outline-thickness");
    let ballFillColor = globalStyle.getPropertyValue("--ball-fill-color");
    for(let i = 0; i<this.balls.length; i++){
        if(this.ballFlares[i].length>0){
            let pos1 = getCoords(ctx, this.ballFlares[i][0]);
            let pos2 = undefined;
            ctx.beginPath();
            ctx.moveTo(pos1.x, pos1.y);
            for(let j = 1; j<this.ballFlares[i].length; j++){
                pos2 = getCoords(ctx, this.ballFlares[i][j]);
                let grd = ctx.createLinearGradient(pos1.x, pos1.y, pos2.x+(pos2.x-pos1.x)*j, pos2.y+(pos2.y-pos1.y)*j);
                grd.addColorStop(0, "transparent");
                grd.addColorStop(1, "white");
                ctx.lineTo(pos2.x, pos2.y);
                ctx.lineWidth = ballOutlineThickness;
                ctx.strokeStyle = grd; 
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(pos2.x, pos2.y);
                pos1 = pos2
            }
        }
        ctx.beginPath();
        let pos = getCoords(ctx, this.balls[i].pos);
        ctx.arc(pos.x, pos.y, getLength(ctx, 0.1), 0, 2 * Math.PI);
        ctx.strokeStyle = ballOutlineColor; 
        ctx.lineWidth = ballOutlineThickness;
        ctx.fillStyle = ballFillColor; 
        ctx.stroke();
        ctx.fill();
    }
}
Juggler.prototype.update = function(time){
    if(!this.paused){
        let t = (time - this.startTime)*this.animationSpeed/1000.0;
        this.rhand.update(t);
        this.lhand.update(t);
        for(let i = 0; i<this.balls.length; i++){
            let ball = this.balls[i];
            ball.update(t);
            let arr = this.ballFlares[i];
            if(arr.length == 0 || t-arr[arr.length-1].t>0.01){
                arr.push({x: ball.pos.x, y: ball.pos.y, t: t});
                if(arr.length>this.flareLength){
                    arr.shift();
                }
            }
        }
    }
}

function getCoords(ctx, position){
    return {x: ctx.canvas.width*(1+position.x)/2,
        y: ctx.canvas.height-ctx.canvas.width*(1+position.y)/2};
};
function getLength(ctx, length){
    return ctx.canvas.width * length/2;
};

function Path(throws, data, t1, ball = true){
    this.curves = new Array();
    for(let i = 0; i<data.length; i++){
        let newCurves = new Array();
        let off = data[i][data[i].length-1];
        if(data[i][0] == "b"){
            for(let j = 1; j<data[i].length-1; j++){
                newCurves.push(throws[data[i][j]].offset(off));
            }
        }
        if(data[i][0] == "h"){
            newCurves.push(wildCurveBetween(throws[data[i][1]], throws[data[i][2]]).offset(off));
        }
        if(data[i][0] == "hr"){
            let off2 = data[i][data[i].length-2];
            newCurves.push(wildCurveBetween(throws[data[i][1]], throws[data[i][2]].offset(off2)).offset(off));
        }
        for(let j = 0; j<newCurves.length; j++){
            let c2 = newCurves[j];
            if(!(i==0&&j==0)){
                let c1 = this.curves[this.curves.length-1];
                let c3 = wildCurveBetween(c1,c2);
                this.curves.push(c3);
            }
            this.curves.push(c2);
        }
    }
    let c1 = this.curves[this.curves.length-1];
    let c4 = this.curves[0];
    let c2 = c4.offset(t1-c4.t0);
    let c3 = wildCurveBetween(c1, c2);
    this.curves.push(c3);
};
Path.prototype.draw = function(ctx){
    for(let i = 0; i<this.curves.length; i++){
        this.curves[i].draw(ctx);
    }
};
function PathWalker(path, offset){
    this.path = path;
    this.t = 0;
    this.maxt = path.curves[path.curves.length-1].t1;
    this.mint = path.curves[0].t0;
    this.t%=this.maxt;
    this.index = 0;
    this.offset = offset;
    this.mod = function(n, m) {
        return ((n % m) + m) % m;
    }
    this.pos = {x: 0, y: 0};

    this.update = function(t)
    {
        if(this.t<this.mod((t+this.offset-this.mint),(this.maxt-this.mint))+this.mint){
            this.t = this.mod((t+this.offset-this.mint),(this.maxt-this.mint))+this.mint;
            while(this.path.curves[this.index].t1<this.t){
                this.index++;
            }
            this.pos = path.curves[this.index].getPosition(this.t);
        }else if(this.t>this.mod((t+this.offset-this.mint),(this.maxt-this.mint))+this.mint){
            this.t = this.mod((t+this.offset-this.mint),(this.maxt-this.mint))+this.mint;
            this.index = 0;
            while(this.path.curves[this.index].t1<this.t){
                this.index++;
            }
            this.pos = path.curves[this.index].getPosition(this.t);
        }
    }
};
function Curve(t0, t1){
    this.t0 = t0;
    this.t1 = t1;
    this.getPosition = function(time){};
    this.getSpeed = function(time){};
    this.offset = function(time){};
    this.draw = function(ctx){
    for(let j = Math.ceil(this.t0/0.05)*0.05; j<=this.t1+0.00001; j+=0.05){
            let pos = getCoords(ctx, this.getPosition(j));
            ctx.beginPath();
            ctx.ellipse(pos.x,pos.y,3,3,0,0,2*Math.PI);
            ctx.fill();
        }
    };
};
function wildCurveBetween(c1, c2){
    let p0 = c1.getPosition(c1.t1);
    let p1 = c2.getPosition(c2.t0);
    let v0 = c1.getSpeed(c1.t1);
    let v1 = c2.getSpeed(c2.t0);
    return new WildCurve(p0.x,p0.y,v0.x,v0.y,p1.x,p1.y,v1.x,v1.y,c1.t1,c2.t0);
};
function Point(x, y, t0, t1){
    Curve.call(this, t0, t1);
    this.x = x;
    this.y = y;
    this.getPosition = function(time){
        return {x: this.x, y: this.y};
    }
    this.getSpeed = function(time){
        return {x:0, y:0};
    }
    this.offset = function(time){
        return new Point(this.x, this.y, this.t0+time, this.t1+time);
    }
};
function WildCurve(x0, y0, vx0, vy0, x1, y1, vx1, vy1, t0, t1){
    Curve.call(this, t0, t1);
    let t = t1-t0;
    this.x0 = x0;
    this.y0 = y0;
    this.vx0 = vx0;
    this.vy0 = vy0;
    this.x1 = x1;
    this.y1 = y1;
    this.vx1 = vx1;
    this.vy1 = vy1; 
    this.ax = (vx0+vx1)/(t*t)-2*(x1-x0)/(t*t*t);
    this.bx = 3*(x1-x0)/(t*t)-(2*vx0+vx1)/t;
    this.cx = vx0;
    this.dx = x0;
    this.ay = (vy0+vy1)/(t*t)-2*(y1-y0)/(t*t*t);
    this.by = 3*(y1-y0)/(t*t)-(2*vy0+vy1)/t;
    this.cy = vy0;
    this.dy = y0;
    this.getPosition = function(t){
        let time = t-this.t0;
        let time2 = time*time;
        let time3 = time2*time;
        return {x: this.ax*time3 + this.bx*time2 + this.cx*time + this.dx,
            y: this.ay*time3 + this.by*time2 + this.cy*time + this.dy};
    };
    this.getSpeed = function(t){
        let time = t-this.t0;
        let time2 = time*time;
        return {x: 3*this.ax*time2 + 2*this.bx*time + this.cx,
            y: 3*this.ay*time2 + 2*this.by*time + this.cy};
    };
    this.offset = function(t){
        return new WildCurve(this.x0, this.y0, this.vx0, this.vy0, this.x1, this.y1, this.vx1, this.vy1, this.t0+t, this.t1+t);
    }
};
function Parabola(x0, y0, x1, y1, t0, t1){
    Curve.call(this, t0, t1);
    let t = t1 - t0;
    this.ay = -0.5 * g;
    this.by = (y1 - y0)/t + 0.5 * g * t;
    this.bx = (x1 - x0)/t;
    this.cx = x0;
    this.cy = y0;
    this.getPosition = function(t){
        let time = t-this.t0;
        return {x: this.bx*time + this.cx,
            y: this.ay*time*time + this.by*time + this.cy};
    };
    this.getSpeed = function(t){
        let time = t-this.t0;
        return {x: this.bx,
            y: 2*this.ay*time + this.by};
    };
    this.offset = function(t){
        let pos = this.getPosition(this.t1);
        return new Parabola(this.cx, this.cy, pos.x, pos.y, this.t0+t, this.t1+t);
    }
};
