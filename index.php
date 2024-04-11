<?php

require_once "src/Player.php";
require_once "src/Game.php";

use Game\Coin\Flip\Player;
use Game\Coin\Flip\Game;

$game = new Game(new Player("Joe", 10000), new Player("Jane", 100));

$game->start();
