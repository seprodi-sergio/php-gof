<?php
    namespace GameOfLife;

    class Cell {
        private $x;
        private $y;
        private $state;

        public function __construct($x, $y){
            $this->x = $x;
            $this->y = $y;
            $this->state = rand(0, 1);
        }

        
        /*
         # ------------------------------
         # Get / Set
         # ------------------------------
        */
        
        public function getState(){
            return $this->state;
        }

        public function setState($state){
            if($state !== 0 && $state !== 1) return false;
            $this->state = $state;

            return true;
        }


        /*
         # ------------------------------
         # Methods
         # ------------------------------
        */

        public function clone(){
            $newCell = new self($this->x, $this->y);
            $newCell->setState($this->getState());
            
            return $newCell;
        }

        public function nextGen($aliveNeighbors){
            // Verify if cell is alive
            if($this->state){
                if($aliveNeighbors < 2){
                    // The cell is alive but has less than 2 alive neighbors so it will be death
                    $this->state = 0;
                }else if($aliveNeighbors > 3){
                    // The cell is alive but has more than 3 alive neighbors so it will be death
                    $this->state = 0;
                }
            }else if($aliveNeighbors == 3){
                // The cell is death but has 3 alive neighbors so it will be born
                $this->state = 1;
            }
        }
    }
?>