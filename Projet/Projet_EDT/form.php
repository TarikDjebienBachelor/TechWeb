	<h2>Projet TW 2010</h2>
	<h3>Gestion d'un emploi du temps hebdomadaire et visualisation sur un site web.</h3>
	<form method="post" action="edt.php?show=0">
		
		<fieldset> <legend>Choix emploi du temps</legend>
		
		<p> Affichage en : 
		<input type="radio" name="type" value="ligne" id="ligne" checked="checked" /> <label for="ligne">Ligne</label>
		<input type="radio" name="type" value="tableau" id="tableau" /> <label for="tableau">Tableau</label> </p>

		<p>
		Choix de l'emploi du temps : 
		<select name="groupe">
			<option value="0" selected="selected">general</option>
			<option value="1">Groupe 1</option>
			<option value="2">Groupe 2</option>
			<option value="3">Groupe 3</option>
			<option value="4">Groupe 4</option>
		</select> </p>
		
		
		<p><input type="submit" value="OK" /></p>
		
		</fieldset>
		
	</form>
	<?php listeTheme () ;?>