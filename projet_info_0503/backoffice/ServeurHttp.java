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
public class ServeurHttp {

    public static void main(String[] args) {    
        HttpServer serveur = null;
        try {
            serveur = HttpServer.create(new InetSocketAddress(8080), 0);
        } catch(IOException e) {
            System.err.println("Erreur lors de la création du serveur " + e);
            System.exit(-1);
        }

        serveur.createContext("/demandeUtilisateur.html", new getUserHandler());
        serveur.createContext("/demandeExistance.html", new GetExistanceHandler());
        serveur.createContext("/demandeInscription.html", new PutInscriptionHandler());
        serveur.setExecutor(null);
        serveur.start();

        System.out.println("Serveur démarré. Pressez CRTL+C pour arrêter le serveur.");
    }

}