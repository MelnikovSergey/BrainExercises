
// Variables
let game = document.querySelector('#game');
let playerBlock = document.querySelector('.player');

let player = {
	x: 50,
	y: 50,
	el: false
};

// Move player
function movePlayer() {
	document.addEventListener('keydown', (event) => {
		console.log(event.keyCode);
	});
}

// Entry point
function startGame() {
	game.innerHTML += `<div class="player" style="left: ${player.x}px; top: ${player.y}px;"></div>`;
	player.el = true;

	// Init func
	movePlayer();
}

startGame();