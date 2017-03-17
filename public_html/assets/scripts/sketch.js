var FinissantHero = {

};
var hero_width = document.getElementById('hero_canvas').offsetWidth;
var hero_height = document.getElementById('hero_canvas').offsetHeight;

var timer = 0;
var total = 0;
var counter = 0;
var step = Math.PI * 2 / 360;

FinissantHero.Main = function (game) {


};

FinissantHero.Main.prototype = {

	preload: function () {
		//game.scale.scaleMode = Phaser.ScaleManager.NO_SCALE;

		game.load.image('chapeau', 'dist/images/canvas/chapeau2.png');
		game.load.image('arrow', 'dist/images/canvas/fleche.png');
		game.load.image('background', 'dist/images/hero_bck_no_pattern@1x.png');

	},

	create: function () {

		game.stage.backgroundColor = '#05b8ec';
		this.background = game.add.sprite(0, 0, 'background');
		this.background.height = game.height;
		this.background.width = game.width;


		game.physics.startSystem(Phaser.Physics.ARCADE);

		this.arrow = game.add.sprite(game.width - 50, game.height + 50, 'arrow');
		this.arrow.anchor.setTo(0.5, 0.5);
		this.arrow.scale.setTo(0.7, 0.7);

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

var game = new Phaser.Game('100%', 360, Phaser.AUTO, 'hero_canvas');
// Ajout de l'état 'mainState' dans Phaser, je lui donne l'index 'main'

game.state.add('Main', FinissantHero.Main);

game.state.start('Main');
//game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;

var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
var android = /android/i.test(navigator.userAgent);
console.log(iOS);
$(window).resize(function () {
	if (iOS === false && android === false){
		resizeGame();
	}
	
});

function resizeGame() {
	if ($(window).width() < 800) {
		$("#hero_canvas").css("display", "none");
	}else{
		if ($(window).width() > 800){
			$("#hero_canvas").css("display", "block");
		}
	}

	var innerWidth = window.innerWidth;
	var innerHeight = window.innerHeight;
	var gameRatio = innerWidth / innerHeight;

	game.width = document.getElementById('hero_canvas').offsetWidth;
	game.height = 360;
	//game.stage.bounds.width = 500;
	//game.stage.bounds.height = 360;
	//game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
	//console.log(game.scale.scaleMode);
	game.scale.refresh();

}