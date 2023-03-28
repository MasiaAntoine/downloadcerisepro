function refreshDiv(divID, chemin) {
    const oReq = new XMLHttpRequest();
    oReq.onload = function() {
        document.getElementById(divID).innerHTML = this.responseText;
    }
    oReq.open("get", chemin, true);
    oReq.send();
}

function goAncre(ancre) {
    window.location.hash = '#';
    window.location.hash = '#ancrePole';
}

function viewPole(arg) {
    if(arg == "bac") {
        refreshDiv("refreshPole", "/assets/extensions/index/poleBac.php");
    }
    if(arg == "bts") {    
        refreshDiv("refreshPole", "/assets/extensions/index/poleBTS.php");
    }
    goAncre("ancrePole");
}

function backPole() {
    refreshDiv("refreshPole", "/assets/extensions/index/allFiliere.php");
    goAncre("ancrePole");
}

//Popup
function popup(arg, mode) {
    if(arg == true) {
        document.getElementById("floue").style.display = "block";
        document.getElementById("popup").style.top = "50%";

        if(mode == 0) { 
            title = "confirmation de validation";
            img = "/images/valid.png";
            form = '<label for="Qualité">Qualité</label><select name="Qualité"><option value="0">Classique</option><option value="1">Parfaite</option><option value="2">Premium</option></select><input type="submit" value="Confirmer" name="Bouton" class="primary">';
            message = "<b>Classique</b>, possède une seule pièce jointe et que les textes ne possède pas trop de détail. <br/><b>Parfaite</b>, possède 2 pièces jointes minimum et que les textes ne possède pas trop de détail. <br/><b>Premium</b>, possède 2 pièces jointes minmum avec une bonne qualité de texte.";
        }
        if(mode == 1) { 
            title = "confirmation du refus";
            img = "/images/refuse.png";
            form = '<label for="Raison">Raison</label><select name="Raison"><option value="0">Fichier PDF incomplet</option><option value="1">Fautes d\'orthographes récurrentes</option><option value="2">Langage incorrect</option><option value="3">Fichier PDF erroné</option></select><input type="submit" value="Refuser" name="Bouton" class="primary">';
            message = "La raison de votre refus sera automatiquement envoyée par email à l'élève relié et concerné par la fiche.";
        }
        if(mode == 2) { 
            title = "Notification";
            img = "/images/text.png";
            form = '';
            message = "<center>Vous devez envoyer une fiche cerise pro corrigée vert foncé ou verte par votre professeur. <br/>Les pièces jointes correspondant à la fiche, doivent être fournies aussi depuis le formulaire.</center>";
        }
        if(mode == 3) { 
            title = "Achat réussi";
            img = "/images/ceriseVertical.png";
            form = '<center>Votre compte a bien été crédité de '+document.getElementById("totalPiece").innerHTML+' pièces cerises.</center>';
            message = "<center>Qu'est-ce que les pièces cerises ? Il s’agit d’une monnaie virtuelle à dépenser dans le site Download Cerise Pro.</br> Les pièces cerises achetées sur une plateforme peuvent ne pas être disponibles sur d’autres plateformes.</center>";
        }

        document.getElementById("title").innerHTML = title;
        document.getElementById("img").src = img;
        document.getElementById("form").innerHTML = form;
        document.getElementById("message").innerHTML = message;
    }
    else if(arg == false) {
        document.getElementById("floue").removeAttribute("style");  
        document.getElementById("popup").removeAttribute("style");

        //Efface le contenu de la popup
        document.getElementById("title").innerHTML = "";
        document.getElementById("img").src = "";
        document.getElementById("form").innerHTML = "";
        document.getElementById("message").innerHTML = "";
    }
}