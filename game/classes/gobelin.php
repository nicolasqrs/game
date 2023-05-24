<?php

require_once('./classes/Ennemi.php');

class Gobelin extends Ennemi
{
    public function __construct()
    {
        $this->pol = 3;
        $this->name = "Gobelin";
        $this->power = 7;
        $this->constitution = 8;
        $this->speed = 7;
        $this->xp = 8;
        $this->gold = 20;
    }

    public function runaway()
    {

    }
}