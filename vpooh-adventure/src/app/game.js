
// Variables
let game = document.querySelector('#game');
let playerContainer = null;

let player = {
	x: 50,
	y: 50,
	step: 5
};

// Init resources
function initResources() {
	game.innerHTML += `<div class="player" style="left: ${player.x}px; top: ${player.y}px;"></div>`;
	playerContainer = document.querySelector('.player');
}

// Move player
function movePlayer() {
	document.addEventListener('keydown', (event) => {
		// console.log(event.keyCode);

		switch (event.keyCode)
		{
		  case 38: 
			// up
			player.y -= player.step;
		  	playerContainer.style.top = `${player.y}px`;
		    	break;

		  case 40:
			// down
			player.y += player.step;  
		    	playerContainer.style.top = `${player.y}px`;
		    break;

		  case 39:
			// left
			player.x += player.step; 
		  	playerContainer.style.left = `${player.x}px`;
		    	break;

		  case 37:
			// right
			player.y -= player.step;
		  	playerContainer.style.left = `${player.x}px`;		    
		    break;

		  default:
			//..		    
		    break;
		}
	});
}

// Entry point
function startGame() {
	initResources();
	movePlayer();
}

startGame();