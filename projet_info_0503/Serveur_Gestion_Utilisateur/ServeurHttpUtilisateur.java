//package Serveur_Gestion_Utilisateur;
import java.io.IOException;
import com.sun.net.httpserver.HttpServer;
import com.sun.net.httpserver.HttpContext;
import java.net.InetSocketAddress;

/**
 * Classe correspondant à un serveur Http simple.
 * Le serveur écoute sur le port 8080 sur le contexte 'index.html'.
 * Le résultat est une simple page qui affiche les données envoyées en POST
 * @author Cyril Rabat
 * @version 2017/10/18
 */
public class ServeurHttpUtilisateur {

    public static void main(String[] args) {    
        HttpServer serveur = null;
        try {
            serveur = HttpServer.create(new InetSocketAddress(8081), 0);
        } catch(IOException e) {
            System.err.println("Erreur lors de la création du serveur " + e);
            System.exit(-1);
        }

        serveur.createContext("/getUtilisateur.html", new UserHandler());
        serveur.createContext("/existe.html", new ExisteHandler());
        serveur.createContext("/inscription.html", new InscriptionHandler());
        serveur.setExecutor(null);
        serveur.start();

        System.out.println("Serveur démarré. Pressez CRTL+C pour arrêter.");
    }

}