# Gioco della vita

Il Gioco della vita è un gioco logico creato da John Horton Conway sul finire degli anni sessanta, la versione implementata usa le seguenti regole:
- Una cella viva muore se ha meno di 2 (Isolamento).
- Una cella viva muore se ha più di 3 celle vicine vive (Sovrapopolazione).
- Una cella morta diventa viva se ha esattamente 3 celle vicine vive (Riproduzione).
- I bordi della tabella di gioco sono collegati al loro lato opposto (Toroide).

Le regole vengono applicate ad ogni nuova generazione.

Il progetto è scritto in PHP ed è eseguibile dal file `main.php` da linea di comando. Accetta 3 parametri:
- `col`: numero di colonne della tabella di gioco. Default: 10
- `row`: numero di righe della tabella di gioco. Default: 10
- `gen`: numero di generazioni da eseguire. Se definito il gioco stampera la tabella per ogni generazione fino a raggiundere la generazione `gen` o al termine del gioco. Il comportamento di default è un loop infinito oppure il game over causato dalla morte di tutte le celle.