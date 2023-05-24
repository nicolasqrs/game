<?php

require_once('./classes/Ennemi.php');

class Geant extends Ennemi
{
    public function __construct()
    {
        $this->pol = 6;
        $this->name = "Geant";
        $this->power = 10;
        $this->constitution = 8;
        $this->speed = 5;
        $this->xp = 15;
        $this->gold = 28;
    }

    public function runaway()
    {

    }
}