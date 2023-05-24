console.log('jeu démarré');

// let permet de déclarer une variable
let box = document.querySelector('.box');
// console.log(box);
let plateau = document.querySelector('.plateau');

let click = 0;
let scoreElement = document.querySelector('#score');

let chrono =30; 
let chronoElement = document.querySelector('#chrono');
chronoElement.innerHTML = chrono;



box.addEventListener("click", () => {

    console.log('click sur la box !');
    click += 1;
    scoreElement.innerHTML = click;
    //math.random sert pour l'aleatoire
    //console.log( Math.floor(Math.random() * window.innerHeight));
    let top  = Math.floor(Math.random() *window.innerHeight);
    let left  = Math.floor(Math.random() *window.innerHeight);

    

    //box.style.top = top +"px";
    //les deux lignes font la meme chose
    box.style.top = `${top}px`;
    box.style.left = `${left}px`;

    //permet de changer la couleur de la variable
    //box.style.backgroundColor = "red";

});

setInterval(() => {
    // Code à exécuter toutes les 30 secondes
    console.log("timer");
    if(chrono != 0){
        chrono--;
        chronoElement.innerHTML = chrono;
    }

  }, 1000);