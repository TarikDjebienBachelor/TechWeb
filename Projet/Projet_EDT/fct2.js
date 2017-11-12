function toggleVisibility(elmt)
{
   if(typeof elmt == "string")
      elmt = document.getElementById(elmt);
   //if(elmt.style.visibility == "hidden")
      elmt.style.visibility = "visible";
}

function toggleVisibilityOut(elmt)
{
   if(typeof elmt == "string")
      elmt = document.getElementById(elmt);
   if(elmt.style.visibility == "visible")
      elmt.style.visibility = "hidden";
}


 /* fonction inArray, renvoie true si la valeur recherchée est dans le tableau*/
 Array.prototype.inArray = function(array) {
	for(var i=0; i<this.length;i++) {
		if(this[i]==array){ return true;}
	}
	return false;
};
 
 /* Fonction affichant et masquant un élément */
 function ShowHide(element){
	if(element.style.display=='none'){
		element.style.display='';
	}else{
		element.style.display='none';
	}
}

function ShowHideClass(className, Tag){
	var elts = document.getElementsByTagName(Tag);
	for (var j=0;j<elts.length;j++) {
		if (elts[j].getAttribute('class') && elts[j].getAttribute('class').split(' ').inArray(className)) {
			ShowHide(elts[j]);
		}
	}
} 

