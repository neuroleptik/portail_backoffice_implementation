//package Serveur_Gestion_Utilisateur;
import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.Headers;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.io.FileInputStream;
import java.io.InputStream;
import java.io.FileWriter;
import java.io.File;
import java.io.OutputStream;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.URI;
import java.net.URLDecoder;

/**
 * Classe correspondant au handler sur le contexte 'index.html'.
 * @author Cyril Rabat
 * @version 2017/11/24
 */
class InscriptionHandler implements HttpHandler {

    public void handle(HttpExchange t) {
        String reponse = "";

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
            
        System.out.println(query); 
        try {
                query = URLDecoder.decode(query, "UTF-8");
            } catch(UnsupportedEncodingException e) {
                query = "";
            } 
        

         // creation du tableau de String pour chaque donnée 
        String data[] = query.split("&");
         for (int i = 0;i < data.length;++i) {
            data[i] = data[i].substring(data[i].indexOf('=')+1);
             System.out.println(data[i]);
         }
        Utilisateur new_user = new Utilisateur(data[0],data[1],data[2],data[3],data[4],"",data[5]); // creation d'une liste de bateau vide
        String user_to_json = new_user.toJSONString();
        try
        {
            File ff=new File("user/"+data[3]+".json"); // définir l'arborescence
            ff.createNewFile();
            FileWriter ffw=new FileWriter(ff);
            ffw.write(user_to_json);  // écrire une ligne dans le fichier resultat.txt
            ffw.close(); // fermer le fichier à la fin des traitements
        } 
        catch (Exception e) 
        {
            System.err.println("Erreur lors de l'ecriture du fichier");
            System.exit(-1);
        }
        
        reponse = "ok";
         System.out.println(reponse); 

        // Envoi de l'en-tête Http
        try {
            Headers h = t.getResponseHeaders();
            h.set("Content-Type", "text/plain; charset=utf-8");
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