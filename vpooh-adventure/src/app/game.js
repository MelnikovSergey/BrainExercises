
// Variables
let game = document.querySelector('#game');
let playerContainer = null;

let player = {
	x: 50,
	y: 50,
	el: false
};

// Init resources
function initResources() {
	game.innerHTML += `<div class="player" style="left: ${player.x}px; top: ${player.y}px;"></div>`;
	playerContainer = document.querySelector('.player');
	player.el = true; 
}

// Move player
function movePlayer() {
	document.addEventListener('keydown', (event) => {
		console.log(event.keyCode);

		switch (event.keyCode)
		{
		  case 38: 
			// up
		  	playerContainer.style.top = `${player.y -= 5}px`;
		    	break;

		  case 40:
			// down  
		    	playerContainer.style.top = `${player.y += 5}px`;
		    break;

		  case 39:
			// left 
		  	playerContainer.style.left = `${player.x += 5}px`;
		    	break;

		  case 37:
			// right
		  	playerContainer.style.left = `${player.x -= 5}px`;		    
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