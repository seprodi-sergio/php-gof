<?php
    require __DIR__ . '/vendor/autoload.php';

    use GameOfLife\Game;

    // Get parameters
    $col = $argv[1] ?? 10;
    $row = $argv[2] ?? 10;
    $gen = $argv[3] ?? null;

    // Init game 
    $game = new Game($col, $row);

    // Run game
    if($gen) $game->run($gen);
    else $game->runLoop();