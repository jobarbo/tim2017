function animationAccueil() {
	
	var ConfettiHero = {

	};

	var hero_width = document.getElementById('hero_canvas').offsetWidth;
	var hero_height = document.getElementById('hero_canvas').offsetHeight;

	var timer = 0;
	var total = 0;
	var counter = 0;
	var step = Math.PI * 2 / 360;

	ConfettiHero.Main = function (game) {};

	ConfettiHero.Main.prototype = {

		init: function() {
			game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL; 
			game.scale.pageAlignHorizontally = true;
			game.scale.pageAlignVertically = true;
			game.stage.smoothed = false;
		},

		preload: function () {
			//game.scale.scaleMode = Phaser.ScaleManager.NO_SCALE;
			game.physics.startSystem(Phaser.Physics.ARCADE);
			game.load.spritesheet('confetti', 'dist/images/canvas/confettiblue.png',30,48,20);
			game.load.image('arrow', 'dist/images/canvas/fleche.png');
			game.load.image('background', 'dist/images/hero_bck_no_pattern@1x.png');

		},

		create: function () {

			game.stage.backgroundColor = '#05b8ec';
			this.background = game.add.sprite(0, 0, 'background');
			this.background.height = game.height;
			this.background.width = game.width;


			this.arrow = game.add.sprite(game.width - 50, game.height + 50, 'arrow');
			this.arrow.anchor.setTo(0.5, 0.5);
			this.arrow.scale.setTo(0.7, 0.7);
			this.arrow.z = 400;

			game.physics.arcade.enable(this.arrow);

			//this.arrow.body.gravity.y = -300;
			this.arrow.body.collideWorldBounds = true;
			//this.arrow.body.bounce.setTo(0.7);


			this.releaseConfettis();
			
		},


		releaseConfettis: function () {

			this.confetti = game.add.sprite(-50, game.world.randomY, 'confetti');
			this.confetti.frame = Math.floor(Math.random()*20);
			game.physics.arcade.enable(this.confetti);
			this.confetti.scale.setTo(1, 1);
			this.confetti.angle = game.rnd.angle();
			this.confetti.body.velocity.x = 100;
			total++;
			timer = game.time.now + 600;

		},
		update: function () {
			
			game.add.tween(this.confetti).to({
				angle: 360
			}, 40000, Phaser.Easing.Linear.None, true);
			game.physics.arcade.collide(this.confetti, this.confetti);

			// Move sprite up and down smoothly for show
			var tStep = Math.sin(counter);
			this.arrow.body.y = 20 + tStep * 20;
			counter += step * 5;

			if (total < 400 && game.time.now+500 > timer) {
				this.releaseConfettis();
				game.world.bringToTop(this.arrow);
			}
		},
	};
	
	var game = new Phaser.Game('100%', 360, Phaser.AUTO, 'hero_canvas');
	game.state.add('Main', ConfettiHero.Main);
	game.state.start('Main');

	var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
	var android = /android/i.test(navigator.userAgent);

	$(window).resize(function () {
		if (iOS === false && android === false) {
			resizeGame();
		}

	});

	function resizeGame() {
		if ($(window).width() < 800) {
			$("#hero_canvas").css("display", "none");
		} else {
			if ($(window).width() > 800) {
				$("#hero_canvas").css("display", "block");
			}
		}

		var innerWidth = window.innerWidth;
		var innerHeight = window.innerHeight;
		var gameRatio = innerWidth / innerHeight;

		game.width = document.getElementById('hero_canvas').offsetWidth;
		game.height = 360;
		game.scale.refresh();
	}
}

function animationDiplome() {
	var FinissantHero = {

	};
	var hero_width = document.getElementById('hero_canvas').offsetWidth;
	var hero_height = document.getElementById('hero_canvas').offsetHeight;

	var timer = 0;
	var total = 0;
	var counter = 0;
	var step = Math.PI * 2 / 360;

	FinissantHero.Main = function (game) {};

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

			this.chapeau = game.add.sprite(-200, game.world.randomY, 'chapeau');
			game.physics.arcade.enable(this.chapeau);

			this.chapeau.anchor.setTo(0.5, 0.5);
			this.chapeau.scale.setTo(0.6, 0.6);

			this.chapeau.angle = game.rnd.angle();

			this.chapeau.body.velocity.x = 100;



			total++;
			timer = game.time.now + 600;

		},
		update: function () {
			game.add.tween(this.chapeau).to({
				angle: 360
			}, 30000, Phaser.Easing.Linear.None, true);
			game.physics.arcade.collide(this.chapeau, this.chapeau);


			// Move sprite up and down smoothly for show
			var tStep = Math.sin(counter);
			this.arrow.body.y = 20 + tStep * 20;
			counter += step * 5;

			if (total < 300 && game.time.now-200 > timer) {
				this.releaseHats();
			}


		},

	};


	var game = new Phaser.Game('100%', 360, Phaser.AUTO, 'hero_canvas');
	// Ajout de l'état 'mainState' dans Phaser, je lui donne l'index 'main'

	game.state.add('Main', FinissantHero.Main);

	game.state.start('Main');
	//game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;

	var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
	var android = /android/i.test(navigator.userAgent);

	$(window).resize(function () {
		if (iOS === false && android === false) {
			resizeGame();
		}

	});

	function resizeGame() {
		if ($(window).width() < 800) {
			$("#hero_canvas").css("display", "none");
		} else {
			if ($(window).width() > 800) {
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




}

	if ($(".accueil").length > 0) {
	
		animationAccueil();
		
	}

	if ($(".diplomes").length > 0) {
		animationDiplome();
	}