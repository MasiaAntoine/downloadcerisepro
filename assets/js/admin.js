// FICHE EN VALIDATION

//Vérifier le clique de la fiche
function validFiche(arg) {
    if(arg == 0) {
        console.log("accepter");
        popup(true, 0);
    }
    else if(arg == 1) {
        console.log("refuser");
        popup(true, 1);
    }
}