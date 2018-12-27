

var requeteHTTP = new XMLHttpRequest(); // Création de l'objet
requeteHTTP.onloadend = handler;        // Spécification de l'handler à exécuter

// Fonction pour récupérer la news suivante
function getJsonUtilisateur(numero_classe) {
    var data = "id_utilisateur="+numero_classe;
    var URL = "http://localhost:8080/index.html"; 
    requeteHTTP.open("POST", URL,true);
    requeteHTTP.send(data);
}

function handler() {
    if((requeteHTTP.readyState == 4) && (requeteHTTP.status == 200)) {
        docJSON = JSON.parse(requeteHTTP.responseText);
        console.log(docJSON.civilite);
        console.log(docJSON.nom);
        console.log(docJSON.prenom);
        console.log(docJSON.adresse_email);
        document.getElementById("message_bonjour").innerHTML = "Bonjour "+docJSON.civilite+" "+docJSON.nom+" "+docJSON.prenom+".";

        var cnt = 0;
        for (i in docJSON.liste_bateaux) cnt++;

        document.getElementById("nombre_bateaux").innerHTML = "Vous avez "+cnt+" bateau(x)."
        
    }	  	
    else {
        alert("Erreur lors de la requête AJaX.");
    }
}

