import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.Headers;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.io.OutputStream;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URI;
import java.net.URLDecoder;

import java.io.InputStreamReader;
import java.io.BufferedReader;
import java.io.OutputStreamWriter;
import java.net.URLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.net.MalformedURLException;

/**
 * Classe correspondant au handler sur le contexte 'index.html'.
 * @author Cyril Rabat
 * @version 2017/11/24
 */
class GetExistanceHandler implements HttpHandler {

    public void handle(HttpExchange t) {

        // Récupération des données
        URI requestedUri = t.getRequestURI();
        String query = requestedUri.getRawQuery();

        // Utilisation d'un flux pour lire les données du message Http
        BufferedReader br = null;
        try {
            br = new BufferedReader(new InputStreamReader(t.getRequestBody(),"utf-8"));
        } catch(UnsupportedEncodingException e) {
            System.err.println("Erreur lors de la récupération du flux " + e);
            System.exit(-1);
        }
 
        // Récupération des données en POST
        try {
            query = br.readLine();
        } catch(IOException e) {
            System.err.println("Erreur lors de la lecture d'une ligne " + e);
            System.exit(-1);
        }

        // Envoie au serveur de gestion Utilisateur.

         // Mise en forme de l'URL
        URL url = null;
        try { 
            url = new URL("http://localhost:8081/existe.html"); 
        } catch(MalformedURLException e) { 
            System.err.println("URL incorrect : " + e);
            System.exit(-1);
        }
 
        // Etablissement de la connexion
        URLConnection connexion = null; 
        try { 
            connexion = url.openConnection(); 
            connexion.setDoOutput(true);
        } catch(IOException e) { 
            System.err.println("Connexion impossible : " + e);
            System.exit(-1);
        } 
 
        // Envoi de la requête
        try {
            OutputStreamWriter writer = new OutputStreamWriter(connexion.getOutputStream());
            writer.write(query);
            writer.flush();
            writer.close();
        } catch(IOException e) {
            System.err.println("Erreur lors de l'envoi de la requete : " + e);
            System.exit(-1);            
        }        
 
        // Réception des données depuis le serveur de gestion Utilisateur
        String reponse = ""; 
        try { 
            BufferedReader reader = new BufferedReader(new InputStreamReader( connexion.getInputStream())); 
            String tmp; 
            while((tmp = reader.readLine()) != null) 
                reponse += tmp; 
            reader.close(); 
        } catch(Exception e) { 
            System.err.println("Erreur lors de la lecture de la réponse : " + e);
            System.exit(-1);
        }          

        // Envoi de l'en-tête Http
        try {
            Headers h = t.getResponseHeaders();
            h.set("Content-Type", "application/json; charset=utf-8");
            h.set("Access-Control-Allow-Origin", "*");
            t.sendResponseHeaders(200, reponse.getBytes().length);
        } catch(IOException e) {
            System.err.println("Erreur lors de l'envoi de l'en-tête : " + e);
            System.exit(-1);
        }

        // Envoi du corps (données HTML)
        try {
            OutputStream os = t.getResponseBody();
            os.write(reponse.getBytes());
            os.close();
        } catch(IOException e) {
            System.err.println("Erreur lors de l'envoi du corps : " + e);
        }
    }

}