//alerte et redirection
function popup_redirection(message_popup,redirection){
    alert(message_popup);
    location.href=redirection; 
}


//Dynamisme des formulaires
function apparaitre(element) {
	element.style.display='block';
	window.scroll(0,1000);
}

function disparaitre(element) {
	element.style.display='none';
}


function redirection(direction){
    location.href=direction; 
}

function popup_et_redirection(elem,redirection){
		var Popup = elem;
		Popup.style.display	= 'block';
		setTimeout(function(){ location.href=redirection; }, 2500);
}

function popup_sans_redirection(elem){
		var Popup = elem;
		Popup.style.display	= 'block';
		setTimeout(function(){Popup.style.display	= 'none'; }, 3000);
}

function popup_et_redirection_texte(elem,texte,redirection){
		var Popup = elem;
		elem.innerHTML = texte;
		Popup.style.display	= 'block';
		setTimeout(function(){Popup.style.display	= 'none'; location.href=redirection; }, 2500);
}


function popup_sans_redirection_texte(elem2,texte){
		var Popup = elem2;
		elem2.innerHTML = texte;
		Popup.style.display	= 'block';
		setTimeout(function(){Popup.style.display	= 'none';}, 2500);													
}

function popup_ouvrante(elem2){
		var Popup = elem2;
		Popup.style.display	= 'block';														
}

function popup_fermante_sans_redirection(elem2){
		var Popup = elem2;
		Popup.style.display	= 'none';														
}


function popup_fermante_avec_redirection(elem2,redirection){
		var Popup = elem2;
		Popup.style.display	= 'none';	
		location.href=redirection;													
}


/*Style du diaporama de la page club*/

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("slide");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}