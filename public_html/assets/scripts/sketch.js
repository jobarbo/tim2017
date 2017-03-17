var HeroImage = {

};
var hero_width = document.getElementById('hero_canvas').offsetWidth;
var hero_height = document.getElementById('hero_canvas').offsetHeight;

var timer = 0;
var total = 0;
var counter = 0;
var step = Math.PI * 3 / 360;

HeroImage.Main = function (game) {


};

HeroImage.Main.prototype = {

	preload: function () {

		game.load.image('chapeau', 'dist/images/canvas/chapeau2.png');
		game.load.image('arrow', 'dist/images/canvas/fleche.png');
		game.load.image('background', 'dist/images/hero_bck_no_pattern@1x.png');

	},

	create: function () {

		game.stage.backgroundColor = '#05b8ec';
		this.background = game.add.sprite(0,0, 'background');
		this.background.height = game.height;
		this.background.width = game.width;


		game.physics.startSystem(Phaser.Physics.ARCADE);

		this.arrow = game.add.sprite(game.width-50, game.height +50, 'arrow');
		this.arrow.anchor.setTo(0.5, 0.5);
		this.arrow.scale.setTo(0.7,0.7);

		game.physics.arcade.enable(this.arrow);

		//this.arrow.body.gravity.y = -300;
		this.arrow.body.collideWorldBounds = true;
		//this.arrow.body.bounce.setTo(0.7);
		

		this.releaseHats();

	},


	releaseHats: function () {
		
		this.chapeau = game.add.sprite(-(Math.random() * 800), game.world.randomY, 'chapeau');
		game.physics.arcade.enable(this.chapeau);


		this.chapeau.scale.setTo(0.5, 0.5);

		this.chapeau.body.bounce.setTo(0.7);

		this.chapeau.angle = game.rnd.angle();

		this.chapeau.body.velocity.x = 200;
		
		

		total++;
		timer = game.time.now + 600;
		
	},



	update: function () {
		game.add.tween(this.chapeau).to({
			angle: 360
		}, 20000, Phaser.Easing.Linear.None, true);
		game.physics.arcade.collide(this.chapeau, this.chapeau);


		// Move sprite up and down smoothly for show
		var tStep = Math.sin(counter);
		this.arrow.body.y = 20 + tStep * 20;
		counter += step;
		
		if (total < 200 && game.time.now > timer) {
			this.releaseHats();
		}


	},



};


//var game = new Phaser.Game(hero_width, hero_height, Phaser.AUTO, 'hero_canvas');
//var game = new Phaser.Game(hero_width, hero_height, Phaser.CANVAS, 'hero_canvas', null, false, true);

var game = new Phaser.Game(hero_width, hero_height, Phaser.AUTO, 'hero_canvas');
// Ajout de l'état 'mainState' dans Phaser, je lui donne l'index 'main'
game.state.add('Main', HeroImage.Main);

game.state.start('Main');










//***** P5.JS */
/*
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
}*/
//** Phaser */