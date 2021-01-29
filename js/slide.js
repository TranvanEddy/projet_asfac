'use strict'
let slide;
let numero = 0;
/*************************************************************************************************/
/* ***************************************** FONCTIONS ***************************************** */
/*************************************************************************************************/
function changeSlideNext() {
    //cacher l'image affichee
    let active = document.querySelector(".active");
    active.classList.remove("active");
    //incrementer numero
    numero++;
    //afficher image suivante
    if (numero > slide.length - 1) {
        numero = 0;
    }
    slide[numero].classList.add("active");
}
function start() {
    //lance la fonction next toutes les 4 secondes
    let timer = setInterval(changeSlideNext, 4000);
}
/*************************************************************************************************/
/* ************************************** CODE PRINCIPAL *************************************** */
/*************************************************************************************************/
slide = document.querySelectorAll(".slider-figure");
start();

