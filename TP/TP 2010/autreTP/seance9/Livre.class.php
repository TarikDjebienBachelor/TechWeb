<?php
class Livre
{
  private $titre; // chaine
  private $auteurs; // tableau de chaines
  private $editeur; // chaine

  public function getTitre(){ return $this->titre; }
  public function getAuteurs(){ return $this->auteurs; }
  public function getEditeur(){ return $this->editeur; }
   
  public function __construct($titre, $auteurs, $editeur="")
   // titre : chaine
   // auteurs : tableau de chaine ou chaine
   // editeur : chaine
  {
     $this->titre = $titre;
     if (is_string($auteurs))
      $this->auteurs=array($auteurs);
     else if (is_array($auteurs))
      $this->auteurs=$auteurs;
     else
        throw new Exception('parametre $auteurs incorrect');
     $this->editeur=$editeur;
  }

  public function imageTR($avecEditeur=false)
  //
  {
   $lesAuteurs = implode(', ',$this->auteurs);
   $s = <<<EOD
  <tr>
   <td>{$this->titre}</td>
   <td>{$lesAuteurs}</td>
EOD;
  if ($avecEditeur)
   $s .= "   <td>{$this->editeur}</td>\n";
   $s .= "  </tr>\n";
   return $s;
  }
}
?>