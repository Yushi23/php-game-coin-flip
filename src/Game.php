<?php

namespace Game\Coin\Flip;

class Game
{
    protected $player1;
    protected $player2;
    protected $flips = 1;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    public function flip()
    {
        return rand(0, 1) ? "орел" : "решка";
    }

    public function start()
    {
        echo <<<EOT
            Шансы выигрыша у каждого игрока:
            {$this->player1->name}: шансы - {$this->player1->odds($this->player2)}
            {$this->player2->name}: шансы - {$this->player2->odds($this->player1)}
        EOT;

        $this->play();
    }

    public function play()
    {
        while (true) {
            //Подбросить моненту
            //Если орел, то п1 получает монету, п2 теряет
            //Если решка, то п1 теряет монету, п2 получает
            if ($this->flip() === "орел") {
                $this->player1->point($this->player2);
            } else {
                $this->player2->point($this->player1);
            }

            //Если у кого-то кол-во монет будет 0, то игра окончена
            if ($this->player1->bankrupt() || $this->player2->bankrupt()) {
                return $this->end();
            }

            $this->flips++;
        }
    }

    public function winner(): Player
    {
        return $this->player1->bank() > $this->player2->bank() ? $this->player1 : $this->player2;
    }


    public function end()
    {
        //Победитель тот, у кого больше монет
        echo <<<EOT
    

            Кол-во монет у каждого игрока:
            {$this->player1->name}: монет - {$this->player1->coins}
            {$this->player2->name}: монет - {$this->player2->coins}

            Победитель: {$this->winner()->name}
            Кол-во подбрасываний: {$this->flips}

        EOT;
    }
}
