<?php
class Room {
    private string $name;
    private string $description;
    private string $type;
    private int $donjon_id;
    private int $or;
    private int $xp;

    public function __construct($room)
    {
        $this->name = $room['name'];
        $this->description = $room['description'];
        $this->type = $room['type'];
        $this->donjon_id = $room['donjon_id'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getHTML(): string
    {
        $html = "";

        switch ($this->type) {
            case 'vide':
                $html .= "<p class='mt-4'><a href='donjon_play.php?id=". $this->donjon_id ."' class='btn btn-green'>Continuer l'exploration</a></p>";
                break;

            case 'treasure':
                $html .= "<p class='mt-4'>Vous avez gagné " . $this->or . " pièce d'or</p>";
                $html .= "<p class='mt-4'><a href='donjon_play.php?id=". $this->donjon_id ."' class='btn btn-green'>Continuer l'exploration</a></p>";
                break;

            case 'combat':
                $html .= "<p class='mt-4'><a href='donjon_fight.php?id=". $this->donjon_id ."' class='me-2 btn btn-green'>Combattre</a>";
                $html .= "<a href='donjon_play.php?id=". $this->donjon_id ."' class='btn btn-blue'>Fuir et continuer l'exploration</a></p>";
                break;
            
                default:
                $html .= "<p>BRAVO !</p>";
                $html .= '<a class="btn btn-primary" href="persos.php">sortir du donjon</a>';
                break;
        }

        return $html;
    }

    public function makeAction(): void
    {
        switch ($this->type) {
            case 'vide':
                break;

            case 'treasur':
                $this->or = rand(15, 50);
                $_SESSION['perso']['gold'] += $this->or;
                break;

            case 'combat':
                break;
            
            default:
                break;
        }
    }
    
    
    public function getXP(): int
    {
        return $this->xp;
    }

    public function setXP(int $xp): void
    {
        $this->xp = $xp;
    }
}
