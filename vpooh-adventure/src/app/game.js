
// Variables
let game = document.querySelector('#game');
let player = document.querySelector('.player');

let player = {
	x: 50,
	y: 50,
	el: false,
};


// Entry point
function startGame() {
	game.innerHTML += `<div class="player" style="left: ${player.x}px; top: ${player.y}px;"></div>`;
	player.el = true;
}

startGame();