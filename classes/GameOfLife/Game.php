<?php
    namespace GameOfLife;

    class Game {
        private $table;
        private $gen;
        private $cols;
        private $rows;
        private $cellAlive;

        private $randomInitialize = true;
        
        public function __construct($cols=10, $rows=10, $random=true){
            $this->cols = $cols;
            $this->rows = $rows;

            $this->randomInitialize = $random;

            $this->init();
        }


        /*
         # ------------------------------
         # Get / Set
         # ------------------------------
        */

        public function getCols(){
            return $this->cols;
        }

        public function getRows(){
            return $this->rows;
        }

        public function getGen(){
            return $this->gen;
        }

        public function getAlive(){
            return $this->cellAlive;
        }

        public function getTable(){
            return $this->table;
        }

        public function getCell($x, $y){
            if(!isset($this->table[$x][$y])) return false;
            return $this->table[$x][$y]->getState();
        }

        public function setCell($x, $y, $state){
            if(!isset($this->table[$x][$y])) return false;
            $this->table[$x][$y]->setState($state);

            if($state) $this->cellAlive++;
            else $this->cellAlive--;

            return true;
        }
        
        protected function getAliveNeighbors($x, $y){
            $alive = 0;

            for($posX=-1; $posX<=1; $posX++){
                for($posY=-1; $posY<=1; $posY++){
                    // Skip center
                    if($posX == 0 && $posY == 0) continue;
                    
                    // Get cursors position
                    $cursor_x = $x + $posX;
                    $cursor_y = $y + $posY;

                    // Left/Right side limit
                    if($cursor_x < 0){
                        $cursor_x = $this->rows + $cursor_x;
                    }elseif($cursor_x >= $this->rows) $cursor_x = $cursor_x - $this->rows;

                    // Top/Bottom side limit
                    if($cursor_y < 0) $cursor_y = $this->cols + $cursor_y;
                    elseif($cursor_y >= $this->cols) $cursor_y = $cursor_y - $this->cols;
 
                    $state = $this->table[$cursor_x][$cursor_y]->getState();
                    if($state) $alive++;
                }
            }
            
            return $alive;
        }


        /*
         # ------------------------------
         # Methods
         # ------------------------------
        */

        public function init(){
            $this->gen = 1;
            $this->cellAlive = 0;
            $this->table = $this->initTable();
        }

        public function initTable(){
            $table = [];
            for($i=0; $i<$this->rows; $i++){
                for($j=0; $j<$this->cols; $j++){
                    $cell = new Cell($i, $j);
                    if(!$this->randomInitialize) $cell->setState(0);
                    if($cell->getState()) $this->cellAlive++;
                    $table[$i][$j] = $cell;
                }
            }
            return $table;
        }

        public function cloneTable(){
            $newTable = [];
            foreach ($this->table as $row) {
                $newRow = [];
                foreach ($row as $cell) {
                    $newRow[] = $cell->clone();
                }
                $newTable[] = $newRow;
            }

            return $newTable;
        }

        public function nextGen(){
            $this->gen++;

            $newTable = $this->cloneTable();
            $newAlive = 0;

            foreach($this->table as $i => $row){
                foreach($row as $j => $cell){
                    $aliveNeighbors = $this->getAliveNeighbors($i, $j);
                    $newTable[$i][$j]->nextGen($aliveNeighbors);
                    if($newTable[$i][$j]->getState()) $newAlive++;
                }
            }

            $this->table = $newTable;
            $this->cellAlive = $newAlive;
        }


        /*
         # ------------------------------
         # Run modes
         # ------------------------------
        */
        
        public function run($gens){
            // Print the initial table
            $this->printTable();

            for($i=1; $i<$gens; $i++){
                $this->nextGen();

                if($this->cellAlive == 0){
                    $this->printGameOver();
                    break;
                }

                $this->printSeparator();
                $this->printTable();
            }
        }

        public function runLoop($anim=true){
            // Clear terminal
            if(PHP_OS == "Linux") echo "\033[H\033[2J";
            else if(PHP_OS == "WINNT") system("cls");
            else echo str_repeat("\n", 30);

            $printFx = $anim ? "printTableClear" : "printTable";
            $this->{$printFx}();

            // Loop until the game is over
            while($this->cellAlive > 0){
                $this->nextGen();
                $this->{$printFx}();
            }

            $this->printGameOver();
        }


        /*
         # ------------------------------
         # Printers
         # ------------------------------
         */

        public function printTable(){
            Render::table($this);
        }

        public function printTableClear(){
            Render::tableClear($this);
        }

        public function printGameOver(){
            Render::gameOver();
        }

        public function printSeparator(){
            Render::separator();
        }
    }