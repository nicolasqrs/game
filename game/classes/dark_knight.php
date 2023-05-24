<?php

require_once('./classes/Ennemi.php');

class DarkKnight extends Ennemi
{
    public function __construct()
    {
        $this->pol = 10;
        $this->name = "DarkKnight";
        $this->power = 13;
        $this->constitution = 15;
        $this->speed = 5;
        $this->xp = 20;
        $this->gold = 100;
    }

    public function fear()
    {

    }
}