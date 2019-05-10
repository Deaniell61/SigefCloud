var config = {
    type: Phaser.AUTO,
    width: 800,
    height: 600,
    physics: {
        default: 'arcade',
        arcade: {
            gravity: {y: 0}
        }
    },
    scene: {
        preload: preload,
        create: create
    }
};

var game = new Phaser.Game(config);

function preload() {
    this.load.image('wheel', 'assets/wheel.png');
    this.load.image('pin', 'assets/pin.png');
}

function create() {
    var wheel = this.physics.add.image(400, 300, 'wheel');
    this.add.image(400, 300, 'pin');

    wheel.body.angle = 30;
}