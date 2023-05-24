
<?php

    session_start();

    function dd($var) {
        echo"<pre>";
        var_dump($var);
        echo "</pre>";

        die();
    }

    function connect () {
        $link = new PDO(
            'mysql:dbname=game2;host=localhost:3307; charset=UTF8',
            'root',
            ''
        );

        return $link;
    } 
    // $id = mysqli_connect("localhost:3307","root","","chat_en_ligne");