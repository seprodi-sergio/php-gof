<?php

namespace GameOfLife\Tests;

use GameOfLife\Game;
use PHPUnit\Framework\TestCase;

class GameOfLifeTest extends TestCase
{
    public function testUnderpopulation()
    {
        $game = new Game(3, 3, false);
        $game->setCell(1, 1, 1);
        $game->nextGen();

        $res = (bool) $game->getCell(1, 1);
        $this->assertFalse($res, "La cella dovrebbe morire per isolamento");
    }

    public function testSurvival()
    {
        // Test in the middle
        $game = new Game(5, 5, false);
        $game->setCell(1, 1, 1);
        $game->setCell(2, 2, 1);
        $game->setCell(3, 3, 1);
        $game->nextGen();

        $res = (bool) $game->getCell(2, 2);
        $this->assertTrue($res, "La cella dovrebbe sopravvivere");

        // Test with border (top/left)
        $game = new Game(5, 5, false);
        $game->setCell(4, 4, 1);
        $game->setCell(0, 0, 1);
        $game->setCell(1, 1, 1);
        $game->nextGen();

        $res = (bool) $game->getCell(0, 0);
        $this->assertTrue($res, "La cella dovrebbe sopravvivere");

        // Test with border (bottom/right)
        $game = new Game(5, 5, false);
        $game->setCell(0, 0, 1);
        $game->setCell(3, 3, 1);
        $game->setCell(4, 4, 1);
        $game->nextGen();
        
        $res = (bool) $game->getCell(4, 4);
        $this->assertTrue($res, "La cella dovrebbe sopravvivere");
    }

    public function testOverpopulation()
    {
        $game = new Game(3, 3, false);
        $game->setCell(1, 0, 1);
        $game->setCell(1, 1, 1);
        $game->setCell(1, 2, 1);
        $game->setCell(0, 1, 1);
        $game->setCell(2, 1, 1);
        $game->nextGen();

        $res = (bool) $game->getCell(1, 1);
        $this->assertFalse($res, "La cella dovrebbe morire per sovrappopolazione");
    }
    
    public function testReproduction()
    {
        $game = new Game(3, 3, false);
        $game->setCell(0, 0, 1);
        $game->setCell(0, 1, 1);
        $game->setCell(1, 0, 1);
        $game->nextGen();

        $res = (bool) $game->getCell(1, 1);
        $this->assertTrue($res, "La cella dovrebbe nascere per riproduzione");
    }
}
