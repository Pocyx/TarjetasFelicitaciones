var score = 0;
var scoreText;
var intervalostars;
var intervaloP;
var platforms;

var text = null;
var textReflect = null;

//Crear objeto juego
var game = new Phaser.Game(400, 550, Phaser.AUTO, 'juego2', {
    preload: preload,
    create: create,
    update: update
});

//Precarga todos los recursos
function preload() {
    game.load.image('sky', 'assets/fondo1.jpg');
    game.load.image('ground', 'assets/platform.png');
    game.load.image('star', 'assets/star.png');
    game.load.spritesheet('dude', 'assets/dude.png', 32, 48);
    game.load.spritesheet('enemigo', 'assets/conejo.png', 450, 350);
    game.load.spritesheet('puerta', 'assets/puerta1.png');
}

function create() {
    game.world.setBounds(0, 0, 800, 1200);
    //  We're going to be using physics, so enable the Arcade Physics system
    game.physics.startSystem(Phaser.Physics.ARCADE);
    //  A simple background for our game
    game.add.sprite(0, 0, 'sky');
    //  The platforms group contains the ground and the 2 ledges we can jump on
    platforms = game.add.group();
    //  We will enable physics for any object that is created in this group
    platforms.enableBody = true;
    // Here we create the ground.
    var ground = platforms.create(0, game.world.height - 64, 'ground');
    //  Scale it to fit the width of the game (the original sprite is 400x32 in size)
    ground.scale.setTo(2, 2);
    //  This stops it from falling away when you jump on it
    ground.body.immovable = true;
    crearLadger();
    crearEnemigo();
    crearPlayer();
    crearEstrella();
    crearPuntuacion();    
    crearPuerta();
    crearTexto();
}

function update() {
    pasarPantalla();
    //  Collide the player and the stars with the platforms
    var hitPlatform = game.physics.arcade.collide(player, platforms);
    moverLedge();
    moverEnemigo()
    moverPlayer();
    //  Allow the player to jump if they are touching the ground.
    if (cursors.up.isDown && player.body.touching.down && hitPlatform) {
        player.body.velocity.y = -350;
        enemy.body.velocity.y = -300;
        //enemy.frame = 4;
    }
    game.physics.arcade.collide(stars, platforms);
    game.physics.arcade.overlap(player, stars, collectStar, null, this);
}

//Funciones --->

function pasarPantalla(){
    if((enemy.body.x <= 50) && (enemy.body.y <= 50)){
        location.href ="level2.html";
    }
}

function moverEnemigo() {
    enemy.body.x = player.body.x;
    enemy.animations.play('right');
    /* if (enemy.x >= 300)
      {
          enemy.scale.x += 0.01;
          enemy.scale.y += 0.01;
      }
     else{
      enemy.scale.x -= 0.01;
      enemy.scale.y -= 0.01;
     }
  */
}

function moverLedge() {
    //  var cont = 0;
    // while(cont < 5){
    if (ledge2.body.x >= 600) {
        ledge2.body.velocity.x = -200;
    } else if (ledge2.body.x <= 1) {
        ledge2.body.velocity.x = 100;
    }
    //   cont++;
    // }
}

function moverPlayer() {
    cursors = game.input.keyboard.createCursorKeys();
//  Reset the players velocity (movement)
    player.body.velocity.x = 0;

    if (cursors.left.isDown) {
        //  Move to the left
        player.body.velocity.x = -150;
        if (player.body.x <= 0) {
            player.body.x = 800;
        }
        player.animations.play('left');
    }
    else if (cursors.right.isDown) {
        //  Move to the right
        player.body.velocity.x = 150;
        if (player.body.x >= 760) {
            player.body.x = 0;
        }
        player.animations.play('right');
    }
    else {
        //  Stand still
        enemy.animations.stop();
        enemy.frame = 1;
        player.animations.stop();
        player.frame = 4;
    }
}

function collectStar(player, star) {
    // Removes the star from the screen
    star.kill();
    //  Add and update the score
    score += 10;
    scoreText.text = 'Score: ' + score;
}

function crearPlayer(){
    // The player and its settings
    player = game.add.sprite(32, game.world.height - 150, 'dude');
    //  We need to enable physics on the player
    game.physics.arcade.enable(player);
    //  Player physics properties. Give the little guy a slight bounce.
    player.body.bounce.y = 0.2;
    player.body.gravity.y = 300;
    player.body.collideWorldBounds = true;
    //  Our two animations, walking left and right.
    player.animations.add('left', [0, 1, 2, 3], 10, true);
    player.animations.add('right', [5, 6, 7, 8], 10, true);
    game.camera.follow(player);
}
function crearEnemigo(){
    //enemy
    // The player and its settings
    enemy = game.add.sprite(32, game.world.height - 850, 'enemigo');
    //  We need to enable physics on the player
    game.physics.arcade.enable(enemy);
    //  Player physics properties. Give the little guy a slight bounce.
    enemy.body.bounce.y = 0.2;
    enemy.body.gravity.y = 300;
    enemy.body.collideWorldBounds = true;
    //  Our two animations, walking left and right.
    enemy.animations.add('left', [0, 1, 2, 3], 10, true);
    enemy.animations.add('right', [5, 6, 7, 8], 10, true);

    enemy.scale.x = 0.2;
    enemy.scale.y = 0.2;

}
function crearPuerta(){
    //enemy
    // The player and its settings
    puerta = game.add.sprite(-50, 10, 'puerta');
    //  We need to enable physics on the player
    game.physics.arcade.enable(puerta);
    //  Player physics properties. Give the little guy a slight bounce.
    puerta.body.bounce.y = 0.2;  
    puerta.body.gravity.y = 0;
    puerta.body.collideWorldBounds = true;
    

    puerta.scale.x = 0.2;
    puerta.scale.y = 0.2;

}
function crearLadger(){
    //  Now let's create two ledges
    //1
    var ledge = platforms.create(50, 400, 'ground');
    ledge.body.immovable = true;
    //2
    ledge = platforms.create(-150, 250, 'ground');
    ledge.body.immovable = true;
    //3
    ledge = platforms.create(500, 210, 'ground');
    ledge.body.immovable = true;
    //4
    ledge = platforms.create(500, 500, 'ground');
    ledge.body.immovable = true;
    //5
    ledge = platforms.create(100, 800, 'ground');
    ledge.body.immovable = true;
    //6
    ledge = platforms.create(500, 1000, 'ground');
    ledge.body.immovable = true;
    //contadorP = 0;
    //moviles
    ledge2 = platforms.create(0, 110, 'ground');
    ledge2.body.immovable = true;
    ledge2 = platforms.create(0, 650, 'ground');
    ledge2.body.immovable = true;
    game.physics.arcade.enable(ledge2);
    /*intervaloP = setInterval(function(){
    // ledge = platforms.create(contadorP, 110, 'ground');
        ledge2 = platforms.body.velocity.x = -150;
        contadorP++;
        if (contadorP==800) clearInterval(intervaloP);       
    },1000);*/
}

function crearEstrella(){
    stars = game.add.group();
    stars.enableBody = true;
    contador = 0;
    intervalostars = setInterval(function () {
        var izda = Math.floor(Math.random() * 800);
        var arriba = Math.floor(Math.random() * 520);
        //  Create a star inside of the 'stars' group
        var star = stars.create(izda, arriba, 'star');
        //  Let gravity do its thing
        star.body.gravity.y = 6;
        //  This just gives each star a slightly random bounce value
        star.body.bounce.y = 0.7 + Math.random() * 0.2;
        contador++;
        if (contador == 20) clearInterval(intervalostars);
    }, 1000);
}

function crearPuntuacion(){
    scoreText = game.add.text(16, 16, 'El conejo te sigue! Ayudalo a llegar a lo más alto.',
     { fontSize: '32px', fill: '#FBF6F8' });
    scoreText.fixedToCamera = true;
    scoreText.cameraOffset.setTo(10, 500);
}
 
function crearTexto(){
    text = game.add.text(game.world.centerX, game.world.centerY, "- Level 1 -");

    //  Centers the text
    text.anchor.set(0.5);
    text.align = 'center';

    //  Our font + size
    text.font = 'Arial';
    text.fontWeight = 'bold';
    text.fontSize = 70;
    text.fill = '#ffffff';

    //  Here we create our fake reflection :)
    //  It's just another Text object, with an alpha gradient and flipped vertically

    textReflect = game.add.text(game.world.centerX, game.world.centerY + 50, "- Level 1 -");

    //  Centers the text
    textReflect.anchor.set(0.5);
    textReflect.align = 'center';
    textReflect.scale.y = -1;

    //  Our font + size
    textReflect.font = 'Arial';
    textReflect.fontWeight = 'bold';
    textReflect.fontSize = 70;

    //  Here we create a linear gradient on the Text context.
    //  This uses the exact same method of creating a gradient as you do on a normal Canvas context.
    var grd = textReflect.context.createLinearGradient(0, 0, 0, text.canvas.height);

    //  Add in 2 color stops
    grd.addColorStop(0, 'rgba(255,255,255,0)');
    grd.addColorStop(1, 'rgba(255,255,255,0.08)');

    //  And apply to the Text
    textReflect.fill = grd;
}