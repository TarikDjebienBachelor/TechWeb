
<!-- Pack des fonctions utilisees-->

<?php 

// permet de recuperer les informations
// d'une ligne et de les tocker dans une
// tableau.
function RecupLigne($ligne)
{
	$ret = '';
	for ( $i = 0 ; $i < strlen($ligne) ; $i ++ ) {
		if ( $ligne[$i] == ';' ){
		$tab[] = $ret  ;
		$ret = '';
		} else {
			$ret = $ret.$ligne[$i] ;
		}
	}

	$tab[] = $ret  ;
	
	return $tab ;
} // end de RecupLigne

/********************************************************************/

// traduit le type abrégé en
// son nom complet
function TypeDe($type)
{
	/* initialisation de variable */
	$bool = 0 ;
	$types = fopen('data/types.txt', 'r+');
	
	/*boucle pour balayer tout le fichier*/
	while ( $bool == 0 ) {
	
		/*lecture de la ligne */
		$line = fgets($types);
	
		/*recuperation du debut de la ligne */
		$debut = strtok($line , ";") ;
	
		if ( $type == $debut ) {
			$debut = strtok( ";" );
			$bool = 1 ;
			return $debut ;
		}
		
	} // end de bool
	
	fclose($types);
	return 'erreur de type' ;
	
} // end de TypeDe

/********************************************************************/

// traduit le theme abrégé en
// son nom complet
function ThemeDe($theme)
{
	/* initialisation de variable */
	$bool = 0 ; $cpt = 0 ;
	$themes = fopen('data/themes.txt', 'r+');
	
	/*boucle pour balayer tout le fichier*/
	while ( $bool == 0 ) {
	
		/*lecture de la ligne */
		$line = fgets($themes);
	
		/*recuperation du debut de la ligne */
		$tab = explode(';',$line) ;
		//echo $tab[0].'='; echo $theme.' donc '.strnatcmp($tab[0],$theme).' ET ' ;//gros pb
		
		
		if ( $tab[0] == $theme ) {
			return $tab[1] ;
			$bool = 1 ;
		}
		
		if ( $cpt > 15 ) { $bool = 1 ;}
		
		$cpt++;
		
		
	
	} // end de bool
	
	fclose($themes);
	return 'Automates et Langages' ;
	
} // end de ThemeDe

/********************************************************************/

// genere le code XHTML pour une
// activité prend en entree un tableau
// généré par RecupLigne
// utiliser pour l'affichage en ligne
function activity($tab , $id , $nbJour , $g) {
	echo '
	<div class="activite activite'.$tab[1].'" id="act_'.$g.$nbJour.$id.'">
	<span class="type type_'.$tab[0].'">'.TypeDe($tab[0]).'</span>
	<span class="theme theme_'.$tab[1].'">'.ThemeDe($tab[1]).'</span>
	<span class="groupe groupe_'.$tab[2].'">'.$tab[2].'</span>
	<span class="jour">'.$tab[3].'</span>
	<span class="debut">'.$tab[4].'h'.$tab[5].'</span>
	<span class="fin">'.$tab[6].'h'.$tab[7].'</span>
	<span class="lieu">'.$tab[8].'</span>
	</div> ' ;
} // end de activity

/********************************************************************/

// genere le code XHTML pour une  
// activité prend en entree un tableau
// généré par RecupLigne
// utiliser pour l'affichage en tableau
// donc une version simplifiée ( sans la salle...)
// et un code en hidden qui sera representeé dans une bulle
function activity2($tab , $id , $nbJour , $g) {
	echo '
	<div class="activite activite'.$tab[1].'" id="act_'.$g.$nbJour.$id.'" onclick="toggleVisibility(\'act_'.$g.$nbJour.$id.'hidden\')" onclick="toggleVisibilityOut(\'act_'.$g.$nbJour.$id.'hidden\')">
	<span class="type type_'.$tab[0].'">'.TypeDe($tab[0]).'</span>
	<span class="theme theme_'.$tab[1].'">'.$tab[1].'</span> ';
	if ( $tab[2] != 0 ) { // si le groupe vaut 0 on ne l'affiche pas
	echo '<span class="groupe groupe_'.$tab[2].'">grp '.$tab[2].'</span>';
	}
	echo '</div> ' ;
	
	/* on creer une version cacher pour la bulle*/
	echo '
	<div class="activitehidden" id="act_'.$g.$nbJour.$id.'hidden">
	<span class="type type_'.$tab[0].'">'.TypeDe($tab[0]).'</span>
	<span class="theme theme_'.$tab[1].'">'.ThemeDe($tab[1]).'</span>';
	if ( $tab[2] != 0 ) { // si le groupe vaut 0 on ne l'affiche pas
	echo '<span class="groupe groupe_'.$tab[2].'"> groupe '.$tab[2].'</span>';
	}
	echo'
	<br/><span class="jour">'.$tab[3].'</span>
	<span class="debut">'.$tab[4].'h'.$tab[5].'</span>
	<span class="fin">'.$tab[6].'h'.$tab[7].'</span> <br/>
	<span class="lieu">'.$tab[8].'</span>
	</div> ' ;
	
} // end de activity

/********************************************************************/

// permet le tri par rapport 
// au 4eme element d'un array
function compare ( $x , $y ) {
	if ( $x[4] == $y[4] ) {
		return 0 ;
	} else if ( $x[4] < $y[4] ) {
		return -1 ;
	} else {
		return 1 ;
	}
}

/********************************************************************/

// genere l'affichage en ligne d'une journee 
// pour un groupe précis réutilisée pour genere
// l'affiche total
function emploiDuTemps ( $jour , $groupe ) {
	
	
	/*ouvertur du bloc div pour la journee*/
	echo '<div class="jour jour_'.$jour.'L">' ;
	echo '<h3>'.$jour.'</h3>';
	
	/* ouverture du fichier */
	$edt = fopen('data/edt.txt', 'r+');

	/* boucle pour parcourir tout le fichier edt.txt */
	while ( !feof($edt) ) {

		/* on recupere la ligne du fichier */
		$line = fgets($edt);

		/* on stock dans un tableau toutes les informations de la ligne */
		$tabs = RecupLigne($line) ;
		
		/* on teste le groupe */
		if ( ($tabs[2] == $groupe || $tabs[2] == 0 || $groupe == -1)  && $tabs[3] == $jour) {
			$tabDetabs[] = $tabs ;
		}
	}
	
	/* on tri le tableau à 2D en fonction de la fonction compare */
	usort ( $tabDetabs , 'compare' ) ;
	
	/* affichage du contenu de l'array trié en activité */
	for ( $i =0 ; $i < sizeof( $tabDetabs ) ; $i++ ) {
		activity( $tabDetabs[$i] , $i , $groupe , NbJour( $jour ) ) ;
	}
	
	/*ouvertur du bloc div pour la journee*/
	echo '</div>' ;
	
	/* fermeture du fichier */
	fclose($edt);
}

/********************************************************************/

// genere l'affiche en ligne pour un seul groupe
function affichageEnLigne ( $groupe ) {
	echo '<div class="jourG">';
	emploiDuTemps ( "lundi" , $groupe  ) ;
	echo '</div>';
	echo '<div class="jourG">';
    emploiDuTemps ( "mardi" , $groupe  ) ;
	echo '</div>';
	echo '<div class="jourG">';
    emploiDuTemps ( "mercredi" , $groupe  ) ;
	echo '</div>';
	echo '<div class="jourG">';
    emploiDuTemps ( "jeudi" , $groupe  ) ;
	echo '</div>';
	echo '<div class="jourG">';
	emploiDuTemps ( "vendredi" , $groupe  ) ;
	echo '</div>';

}

/********************************************************************/

// retourne un tableau à deux dimensions
// contient toute les informations sur
// l'emploi du temps d'un groupe pour un jour donne
function tabEDT ( $jour , $groupe ) {
	/* ouverture du fichier */
	$edt = fopen('data/edt.txt', 'r+');

	/* boucle pour parcourir tout le fichier edt.txt */
	while ( !feof($edt) ) {

		/* on recupere la ligne du fichier */
		$line = fgets($edt);

		/* on stock dans un tableau toutes les informations de la ligne */
		$tabs = RecupLigne($line) ;
		
		/* on teste le groupe */
		if ( ($tabs[2] == $groupe || $tabs[2] == 0 || $groupe == -1)  && $tabs[3] == $jour) {
			$tabDetabs[] = $tabs ;
		}
	}
	
	/* on tri le tableau à 2D en fonction de la fonction compare */
	usort ( $tabDetabs , 'compare' ) ;
	
	/* fermeture du fichier */
	fclose($edt);
	
	/* retour du tableau contenant les info pour 1 journee et 1 grp donné*/
	return $tabDetabs ;
}

/********************************************************************/

// renvoi le numero du jour
function NbJour ( $jour ) {
	if ($jour == "lundi" ) { return 1 ; }
	else if ($jour == "mardi" ) { return 2 ; }
	else if ($jour == "mercredi" ) { return 3 ; }
	else if ($jour == "jeudi" ) { return 4 ; }
	else { return 5 ; }
}

/********************************************************************/

// Calcule le pourcentage pour chaque jour
// inutile dans cette version final
function PrJour ( $jour ) {
	if ($jour == 1 ) { return 0 ; }
	else if ($jour == 2 ) { return 20 ; }
	else if ($jour == 3 ) { return 40 ; }
	else if ($jour == 4 ) { return 60; }
	else { return 80 ; }
}

/********************************************************************/

// affiche l'emploi du temps pour une journee donnee
// normalement plus utiliser dans cette version final
function affichageEnTableparJour ( $jour ) {

	/* on ouvre la balise correspondante au jour */
	echo '<div class="jour_'.$jour.'">';

	for ($groupe = 1 ; $groupe < 5 ; $groupe++ ) {
	
		$tab2d = tabEDT ( $jour , $groupe ) ; 
		$nbAct = sizeof( $tab2d ) ;
		
		for ( $i =0 ; $i < $nbAct ; $i++ ) {
			$tabDeb[] = (((($tab2d[$i][4]-8) * 60) + $tab2d[$i][5]) /600) *100 ;
			$tabFin[] = (100 -(((($tab2d[$i][6]-8) * 60) + $tab2d[$i][7]) /600) *100) ;
			activity( $tab2d[$i] , $i , $groupe , 1) ;	
		}
	
		echo '<style>';
	 
		for ( $j =0 ; $j < $nbAct ; $j++ ) {
			$wid = 100-$tabDeb[$j]-$tabFin[$j] ;
			$down = 100 - (25*($groupe-1)) ;
			$up = 25*($groupe-1) ;
			echo '#act_'.$groupe.$j.'1 { 
			position : absolute ;
			left : '.$tabDeb[$j].'% ;
			right : '.$tabFin[$j].'% ;
			top : '.$up.'% ;
			bottom : '.$down.'% ;
			width :'.$wid.'% ;
			height : 25% ;
			border : black solid 1px ; 
			overflow : hidden ;
			}';
		}
	
		echo '</style>';
	
		reset ( $tabDeb );
		reset ( $tabFin );
	}
	
	/* on ferme la balise correspondante au jour */
	echo '</div>';
}

/********************************************************************/

// affiche l'emploi du temps en tableau et gere son affichage en css
function affichageEnTableparGroupe2 ( $tab2d ) {

	/* on calcule le nbre d'activite */
	$nbAct = sizeof( $tab2d ) ;
	
	/* on recupere le groupe */
	$groupe = $tab2d[0][2] ;
	
	/* et le nombre du jour */
	$H = NbJour ( $tab2d[0][3] ) ;
	
	/* pour chaque activite */
	for ( $i =0 ; $i < $nbAct ; $i++ ) {
		
		/* on stock l'heure du debut et fin dans un tab et on calcule tt de suite leur place*/
		$tabDeb[] = (((($tab2d[$i][4]-8) * 60) + $tab2d[$i][5]) /600) *100 ;
		
		$tabFin[] = (100 -(((($tab2d[$i][6]-8) * 60) + $tab2d[$i][7]) /600) *100) ;

		/* on creer l'activité*/
		activity2( $tab2d[$i] , $i , $groupe, $H) ;
		
	}// end for
	
	// on passe maintenant au style css
	echo '<style>';
	 
	/* pour chaque activité on genere le code associe à l'id former dans activity2 */
	for ( $j =0 ; $j < $nbAct ; $j++ ) {
		$wid = 100-$tabDeb[$j]-$tabFin[$j] ;
		$down = 100 - (25*($groupe)) ;
		$up = 25*($groupe-1);
		echo '#act_'.$H.$groupe.$j.' { 
		position : absolute ;
		left : '.$tabDeb[$j].'% ;
		right : '.$tabFin[$j].'% ;
		top : '.$up.'% ;
		bottom : '.$down.'% ;
		width :'.$wid.'% ;
		height  25% ;
		border : black solid 1px ; 
		overflow : hidden ;
		display : ;
		}';
		 
		/* cree un style cacher pour la bulle */
		echo '#act_'.$H.$groupe.$j.'hidden { 
		position : fixed ;
		left : 78% ;
		right : 5% ;
		top : 40% ;
		bottom : 40% ;
		border : orange solid 3px ; 
		overflow : hidden ;
		background :  yellow ;
		visibility : hidden ;
		font-size : 150% ;
		text-align : center ;
		}';
	}// end for
	
	echo '</style>';
}

/********************************************************************/

// affiche l'emploi du temps total 
// de tout les groupes fonctionne
// comme la fct tabparGrp ( suivante ) 
// sauf que ici c'est pour tt les groupes
function total() 
{
	echo '<div class="jour_lundi">';
	div ("lundi") ; tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "lundi" , 1 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "lundi" , 2 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "lundi" , 3 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "lundi" , 4 ) ) ;
	echo '</div> <br/>';

	echo '<div class="jour_mardi">';
	div ("mardi") ; tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "mardi" , 1 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mardi" , 2 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mardi" , 3 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mardi" , 4 ) ) ;
	echo '</div><br/>';

	echo '<div class="jour_mercredi">';
	div ("mercredi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "mercredi" , 1 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mercredi" , 2 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mercredi" , 3 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "mercredi" , 4 ) ) ;
	echo '</div><br/>';

	echo '<div class="jour_jeudi">';
	 div ("jeudi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "jeudi" , 1 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "jeudi" , 2 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "jeudi" , 3 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "jeudi" , 4 ) ) ;
	echo '</div>';

	echo '<div class="jour_vendredi">';
	 div ("vendredi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "vendredi" , 1 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "vendredi" , 2 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "vendredi" , 3 ) ) ;
	affichageEnTableparGroupe2 ( tabEDT ( "vendredi" , 4 ) ) ;
	echo '</div>';
}

/********************************************************************/

// affiche l'emploi du temps pour un
// groupe precis pris en parametre
function tabParGrp ( $groupe ) 
{
	echo '<div class="jour_lundi">';
	div ("lundi") ; // ecrit LUN et le place devant la journee
	tableauTime () ; // fait le tableau de fond en pointiller
	affichageEnTableparGroupe2 ( tabEDT ( "lundi" , $groupe ) ) ;
	echo '</div> <br/>';

	echo '<div class="jour_mardi">';
	div ("mardi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "mardi" , $groupe ) ) ;
	echo '</div><br/>';

	echo '<div class="jour_mercredi">';
	div ("mercredi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "mercredi" , $groupe ) ) ;
	echo '</div><br/>';

	echo '<div class="jour_jeudi">';
	 div ("jeudi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "jeudi" , $groupe ) ) ;
	echo '</div>';

	echo '<div class="jour_vendredi">';
	 div ("vendredi") ;tableauTime () ;
	affichageEnTableparGroupe2 ( tabEDT ( "vendredi" , $groupe ) ) ;
	echo '</div>';

}

/********************************************************************/

// fonction qui crée les encadrements pour 
// afficher les journees dans l'affiche en tableau
function div ( $string )
{
	//on passe la chaine en majuscule
	$str = strtoupper ($string) ;
	
	// on ouvre une balise div pour le css
	echo '<div id="format'.$string.'"';
		// on ecrit le premier caractere
		echo $str[0].'<br/>' ;
		// on ecrit les 2 suivants
		for ( $i = 0 ; $i < 3 ; $i++) {
			echo $str[$i].'<br/>' ;
		}
	echo '</div>' ;
}

/********************************************************************/

// fonction qui recupère tous les themes existant
// et les place dans un tableau
function listeTheme () 
{
	// on ouvre le fichier des themes
	$themes = fopen('data/themes.txt', 'r+');
	
	// tant qu'on n'est pas à la fin du fichier
	while ( !feof($themes) ) {
	
		// on recupere la ligne en cour
		$line = fgets($themes);
	
		// on recupere les donnees de la ligne dans un tableau et on l'empile dans tab
		// sachant que ici le tab[i][0] sera le theme court
		// tab[i][1] le theme version longue
		$tab[] = RecupLigne($line);
	}
	
	// on ferme le fichier des themes
	fclose($themes) ;

	// on renvoi le tableau
	return $tab ;
}

/********************************************************************/

// creation des boutons qui cache les autres themes
// les boutons formeront le menu (en formulaire)
// et lanceront par onclick les fonction js associé
function createButton( $H ) 
{
	// on recupere la liste des themes
	$liste = listeTheme() ;
	
	// on cree le div menu
	echo '<div id="menu'.$H.'"> ';
	
	// pour chaque elements de la liste
	for ( $i =1 ; $i< sizeof($liste) ; $i++ ) {
	
	// ouvre un div class boutton pour le css
	echo '<div class="boutton" >';
	
	// création du boutton avec lancement de fonction
	echo '<input type="button" value="'.$liste[$i][0].'" onclick="ShowHideClass(\'activite'.$liste[$i][0].'\', \'*\');ShowHideClass(\'activite\', \'*\')" 
														onclick="ShowHideClass(\'activite'.$liste[$i][0].'\', \'*\');ShowHideClass(\'activite\', \'*\')"/>';
	
	//on ferme la balise div
	echo '</div>';
	
	} // end for
	
	// on ferme le div du menu
	echo '</div>';

}

/********************************************************************/

// creer un tableau jsute pour faire beau
// c'est celui qui est en fond de l'edt
function tableauTime () 
{
	echo '<table>' ;
	for ( $j=0 ; $j<4 ; $j++) {
		echo '<tr>' ;
		for ( $i=0 ; $i<10 ; $i++) {
			echo '<td></td>' ;
		}
		echo '</tr>' ;
	}
	
	echo '</table>' ;
	echo '<style> table {width : 100% ; height : 100% ;border-collapse:collapse;border : black solid 2px ;}
				  td {border : black dotted 1px ; width : 10% ; height : 22% ;} </style>';
}


/********************************************************************/

//creer un tableau jsute pour faire beau
// c'est celui tt en haut qui affiche l'heure
function tableauHeure () 
{
	echo '<table id="heure" >' ;
		echo '<tr>' ;
		for ( $i=0 ; $i<10 ; $i++) {
			echo '<td class="h">'; echo $i+8 ; echo'h</td>' ;
		}
	
	
	echo '</table>' ;
	
	echo '<style> #heure {width : 60% ; height : 2% ; border-collapse:collapse; position : absolute ; left : 15% ; right : 25% ; bottom : 90% ; top : 8% ; border : none;}
				  .h {border : none ; border-left : black solid 2px ; border-right : black solid 2px ; text-align : left ;} </style>';
}





















?>
