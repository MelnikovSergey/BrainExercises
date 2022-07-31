(function(id) {
	'use strict';

	// Const
	const FPS = 1000 / 60;
	const keyCodeArray = [38, 40, 39, 37];
	
	// Variables
	let game = document.querySelector('#game');
	let playerContainer = null;
	
	let player = {
		x: 50,
		y: 50,
		step: 5,
		move: false,
		direction: null // 1 - up, 2 - down, 3 - left, 4 - right 
	};
	
	let intervals = {
		run: false
	}
	
	// Init resources
	function initResources() {
		game.innerHTML += `<div class="player" style="left: ${player.x}px; top: ${player.y}px;"></div>`;
		playerContainer = document.querySelector('.player');
	}
	
	// Init intervals
	function initIntervals() {
		intervals.run = setInterval(() => {
	
			if(player.move === true) {
	
				switch (player.direction)
				{
			  	  case 1: 
					// up
					player.y -= player.step;
			  		playerContainer.style.top = `${player.y}px`;
			    		break;
	
			  	  case 2: 
					// down
					player.y += player.step;  
			    		playerContainer.style.top = `${player.y}px`;
			   		break;
	
			  	  case 3: 
					// left
					player.x += player.step; 
			  		playerContainer.style.left = `${player.x}px`;
					toggleDirection();
			    		break;
	
			  	  case 4: 
					// right
					player.x -= player.step;
			  		playerContainer.style.left = `${player.x}px`;
					toggleDirection();	    
					break;
				}
			}
	
		}, FPS);
	}
	
	// Move player
	function movePlayer() {
		document.addEventListener('keydown', (event) => {
	
			switch (event.keyCode)
			{
			  case 38: 
				player.move = true;
				player.direction = 1;
				console.log('Move up');
				break;
	
			  case 40:
				player.move = true;
				player.direction = 2;
				console.log('Move down');
				break;
	
			  case 39:
				player.move = true;
				player.direction = 3;
				console.log('Move left');
				break;
	
			  case 37:
				player.move = true;
				player.direction = 4;
				console.log('Move right');
				break;
			}
		});
	
		document.addEventListener('keyup', (event) => {
			
			if(keyCodeArray.includes(event.keyCode)) {
				player.move = false;
				console.log('KeyUp ' + event.keyCode);
			}
		
		});
	}

	// Toggle direction
	function toggleDirection() {
		if(player.direction == 3) 
			playerContainer.classList.remove('mirrorAnSpriteHorizontally');
		if(player.direction == 4) 
			playerContainer.classList.add('mirrorAnSpriteHorizontally');
	}
	
	// Entry point
	function startGame() {
		initResources();
		initIntervals();
		movePlayer();
	}
	
	startGame();

}(document));