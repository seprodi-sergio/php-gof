<?php
    namespace GameOfLife;

    class Render {
        public static function head($gen, $cells){
            echo "Generation: ".str_pad($gen, 4, "0", STR_PAD_LEFT)."\n";
            echo "Cells alive: ".str_pad($cells, 4, "0", STR_PAD_LEFT)."\n";
            echo "\n";
        }

        public static function table($game){
            self::head($game->getGen(), $game->getAlive());

            $rows = $game->getRows();
            $cols = $game->getCols();
            $table = $game->getTable();

            for($i=0; $i<$rows; $i++){
                for($j=0; $j<$cols; $j++){
                    $state = $table[$i][$j]->getState();

                    $char = $state === 1 ? "O" : " ";
                    echo "|{$char}";
                }
                echo "|\n";
            }

            echo "\n";
        }

        public static function tableClear($game){
            // Start output buffering
            ob_start();

            // Move the terminal cursor to the top
            echo "\033[H";

            self::table($game);

            // Close the output buffering and get the content 
            $output = ob_get_clean();
            echo $output;

            // Delay for 0.1 seconds
            usleep(100000);
        }

        public static function gameOver(){
            echo "!!! Game Over !!!\n";
        }

        public static function separator(){
            echo "-------------------\n\n";
        }
    }

?>