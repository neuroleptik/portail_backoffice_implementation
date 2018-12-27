//package Serveur_Gestion_Utilisateur;
import org.json.*;

public class Utilisateur implements JSONString{

	private String civilite;
	private String nom;
	private String prenom;
	private String adresse_email;
	private String mot_de_passe;
	private String liste_bateaux;
	private String type_utilisateur;

	public Utilisateur(String civilite,String nom,String prenom,String adresse_email,String mot_de_passe,String liste_bateaux,String type_utilisateur){
		this.civilite = civilite;
		this.nom = nom;
		this.prenom = prenom;
		this.adresse_email = adresse_email;
		this.mot_de_passe = mot_de_passe;
		this.liste_bateaux = liste_bateaux;
		this.type_utilisateur = type_utilisateur;
	}

	public Utilisateur(){
		//toast
	}

	public String toJSONString(){
		return "{\"type_utilisateur\":\""+type_utilisateur+"\",\"civilite\" : \""+civilite+"\",\"nom\" : \""+nom+"\",\"prenom\" : \""+prenom+"\",\"adresse_email\" : \""+adresse_email+"\",\"mot_de_passe\" : \""+mot_de_passe+"\",\"liste_bateaux\": []}";
	}
}