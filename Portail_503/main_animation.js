$( "html" ).ready(function() {
    $( "#lien_inscription" ).click(function(){
    $("#tab_connexion").hide();
    $("#tab_inscription").show();
	});

	$( "#lien_connexion" ).click(function(){
    $("#tab_connexion").show();
    $("#tab_inscription").hide();
	});
});
