<?php
class Biblio
{
  private $livres ;// tableau d'instances de Livre
  

  public function getLivres(){ return $this->livres; }
  public function nombre() {return count($this->livres);}

  function __construct($livres=null)
  {
    if ($livres != null)
      $this->livres = $livres;
    else
      $this->livres = array();
  }

  public function add(Livre $l)
  {
    $this->livres[] = $l;
  }

 function imageTable($avecEditeur=false)
 {
   $s = '<table border="1">';
   foreach ($this->livres as $livre)
   { 
      $s .= $livre->imageTR($avecEditeur);
   }
   $s .='</table>';
   return $s;
 }
 
 function addLoad($nomFichier)
 // ajout des livres décrits dans un fichier
 {
    $file = fopen($nomFichier,"r");
    while (! feof($file))
    { // lecture d'une entrée
      $ligne = fgets($file);
      if (! $ligne) throw new Exception("Manque la ligne titre");
      $titre = trim($ligne);

      $ligne = fgets($file);
      if (! $ligne) throw new Exception("Manque la ligne auteurs");
      $auteurs = explode(",",$ligne);
      foreach ($auteurs  as $num=>$auteur)
      { 
        $auteurs[$num]=trim($auteur);
      }

      $editeur = ""; // valeur par defaut
      $ligne = fgets($file);
      if ($ligne && $ligne !="\n")
      { //il y a un éditeur
         $editeur = trim($ligne);
         $ligne = fgets($file);
      }
      if ($ligne && $ligne != "\n")
          throw new Exception("Ligne non vide inattendue");

      $this->add(new Livre($titre,$auteurs,$editeur));
    }
    fclose($file);
 }
}  // fin de classe
?>