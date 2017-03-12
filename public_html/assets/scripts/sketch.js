//***** P5.JS */
// Position Variables
var x = 150;
var y = 150;
 
// Speed - Velocity
var vx = 5;
var vy = 5;
 
// Acceleration
var ax = 1.2;
var ay = 2.6;
 
var vMultiplier = 0.6;
var bMultiplier = 0.6;

var hero_width = document.getElementById('hero_canvas').offsetWidth;
var hero_height = document.getElementById('hero_canvas').offsetHeight;

function setup() {
    //console.log();
    
    var canvas = createCanvas(windowWidth, 360);

    // Move the canvas so it's inside our <div id="sketch-holder">.
    canvas.parent('hero_canvas');
    canvas.id="the_canvas";

    //background(255, 0, 200);
}

function draw() {
    //background(255);
    clear();
    ballMove();
    createBall();
    

}

function createBall(){
    ellipse(x, y, 30, 30);
    fill(0,161,211);
    noStroke();
}

function ballMove() {
    //console.log("test");

	ax = accelerationX;
	ay = accelerationY;

	vx = vx + ay;
	vy = vy + ax;
	y = y + vy * 1; 
	x = x + vx * 1;

	// Bounce when touch the edge of the canvas
	if (x < 0) { 
		x = 0; 
		vx = -vx * 1; 
	}
 	if (y < 0) { 
 		y = 0; 
 		vy = -vy * 1; 
 	}
 	if (x > width - 20) { 
 		x = width - 20; 
 		vx = -vx * 1; 
 	}
 	if (y > height - 20) { 
 		y = height - 20; 
 		vy = -vy * 1; 
 	}


	
}
function windowResized() {
        console.log("resize");
        resizeCanvas(windowWidth, hero_height);
}
//** Phaser */

