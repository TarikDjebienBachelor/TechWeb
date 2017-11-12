

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include ("pack.php") ; ?>

<head>
  <meta content="text/html; charset=UTF-8" http-equiv="content-type" />  
  <meta name="author" content="Noe Pamula - Djebien Tarik" />
  <meta name="reply-to" content="medicalneo@free.fr" />
  <meta name="description" content="Projet de TW - creation d'un emploi du temps" />
  <title>Emploi du temps - Projet TW</title>
  <link rel="stylesheet" media="screen" type="text/css" title="Design" href="design.css" />
  <script type="text/javascript"  src="fct2.js"> </script>
</head>


<body>
<div id="logo">
<img src="images/1742_Lille1.jpg" alt="logo de lille 1" title="logo USTL"/>
</div>

<div id="validator">
<img src="images/valid-xhtml10.png" alt="Xhtml validator" title="logo Xhtml validator"/> <br/>
<img src="images/vcss.gif" alt="CSS validator" title="logo CSS validator"/>
</div>




<?php
	
if ( ! isset ($_GET['show']) OR $_GET['show'] == 1)  {
include ("form.php") ;
}

	if ( isset ($_POST['type']) )  {
	
		if ( $_POST['type'] == "ligne" ) { // si on souhaite un affichage en ligne
			createButton('L') ;
			if ( $_POST['groupe'] == 0 ) {
				for ($g = 1 ; $g<5 ; $g++ ) {
					echo '<div id="edtLine'.$g.'">';
					affichageEnLigne ( $g ) ;
					echo '</div>';
				}
			} else {
				echo '<div id="edtLineSolo">';
				affichageEnLigne ( $_POST['groupe'] ) ;
				echo '</div>';
			}
		
		} else { // sinon c'est en tableau
		
				tableauHeure() ;
				createButton( 'T' ) ;
			if ( $_POST['groupe'] == 0 ) {
				echo '<div id="edtTabTotal">';
				total() ;
				echo '</div>';
			} else {
				echo '<div id="edtTabGrp">';
				tabParGrp ( $_POST['groupe'] );
				echo '</div>';
			}
		}
	
	
		echo '<a href="edt.php?show=1">Retour</a> ' ;
		
	}



?>


</body>


</html>