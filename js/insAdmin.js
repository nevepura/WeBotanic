/*non imposto variabili globali perche' rimarrebbero disponibili anche al di fuori della pagina in cui le utilizzo*/

function caricamentoNotizia() {

    var titolo = document.getElementById('titolo');
    var mese = document.getElementById('mese');
    var giorno = document.getElementById('giorno');
    var form = document.getElementById('formNotizie');
    var immagine = document.getElementById('immagine');
    var corpo = document.getElementById('testoins');
    var alt = document.getElementById('alt');
    

    titolo.setAttribute('onblur', 'checkTitolo(this)');
    mese.setAttribute('onblur','checkData("mese","giorno")');
    giorno.setAttribute('onblur','checkData("mese","giorno")');
    form.setAttribute('onsubmit', 'checkInput()');
    immagine.setAttribute('onblur', 'checkImmagine(this)');
    corpo.setAttribute('onblur', 'checkCorpo(this)');
    alt.setAttribute('onblur', 'checkAlt(this)');  

}

function caricamentoCancella() {
    var del = document.getElementsByClassName('cancella');
    
    for(var i = 0; i < del.length; i++)
        del[i].setAttribute('onclick', 'return conferma()');
}

function conferma() {
    return confirm('Confermare la cancellazione?');
}

function caricamentoEvento() {

    var nome = document.getElementById('nome');
    var meseInizio = document.getElementById('mese_inizio');
    var giornoInizio = document.getElementById('giorno_inizio');
    var meseFine = document.getElementById('mese_fine');
    var giornoFine = document.getElementById('giorno_fine');
    var form = document.getElementById('formEventi');
    var immagine = document.getElementById('immagine');
    var corpo = document.getElementById('testoins');
    var alt = document.getElementById('alt');

    nome.setAttribute('onblur', 'checkTitolo(this)');
    meseInizio.setAttribute('onblur','checkData("mese_inizio","giorno_inizio")');
    giornoInizio.setAttribute('onblur','checkData("mese_inizio","giorno_inizio")');
    meseFine.setAttribute('onblur','checkData("mese_fine","giorno_fine")');
    giornoFine.setAttribute('onblur','checkData("mese_fine","giorno_fine")');
    form.setAttribute('onsubmit', 'checkInput()');
    immagine.setAttribute('onblur', 'checkImmagine(this)');
    corpo.setAttribute('onblur', 'checkCorpo(this)');
    alt.setAttribute('onblur', 'checkAlt(this)');
}

function caricamentoPianta(){

  var ns = document.getElementById('NomeScientifico');
  var nc = document.getElementById('NomeComune');
  var numesemplari = document.getElementById('NumEsemplari');
  var altezza = document.getElementById('AltezzaCm');
  var gruppo = document.getElementById('Gruppo');
  var nomefiore = document.getElementById('nome');
  var colorefiore = document.getElementById('colore');
  var numpetali = document.getElementById('num_petali');
  var nomefrutto = document.getElementById('nome_fr');
  var colorefrutto = document.getElementById('colore_fr');
  var immagine = document.getElementById('img');
  var corpo = document.getElementById('testoins');
  var alt = document.getElementById('alt');

  ns.setAttribute('onblur', 'checkNomiPianta(this)');
  nc.setAttribute('onblur', 'checkNomiPianta(this)');
  numesemplari.setAttribute('onblur', 'checkNumeriPianta(this,100)');
  altezza.setAttribute('onblur', 'checkNumeriPianta(this,8000)');
  gruppo.setAttribute('onchange', 'checkGruppo(this)');
  nomefiore.setAttribute('onblur', 'checkNomiAtt(this)');
  colorefiore.setAttribute('onblur', 'checkNomiAtt(this)');
  numpetali.setAttribute('onblur', 'checkNumeriPianta(this, 20)');
  nomefrutto.setAttribute('onblur', 'checkNomiAtt(this)');
  colorefrutto.setAttribute('onblur', 'checkNomiAtt(this)');
  immagine.setAttribute('onblur', 'checkImmaginePianta(this)');
  corpo.setAttribute('onblur', 'checkCorpo(this)');
  alt.setAttribute('onblur', 'checkAltPianta(this)');

}

function testRegex(exp, val, err){
    if(!exp.test(val.value)) {
        stampaErrore(val.parentElement, err);
        return false;
    }
    else {
        pulisciErrore(val.parentElement);
        return true;
    }
}

function checkAlt(alt) {
    var regex = /^[A-Za-z0-9_\s,&;]{0,200}$/;
    var err = ' Il testo alternativo deve contenere da 0 a 200 caratteri alfanumerici';
    return testRegex(regex, alt, err);
}

function checkAltPianta(alt) {
    var regex = /^[A-Za-z0-9_\s,&;]{5,200}$/;
    var err = ' Il testo alternativo deve contenere da 5 a 200 caratteri alfanumerici';
    return testRegex(regex, alt, err);
}

function checkTitolo(titolo) {
    var regex = /^[a-zA-Z0-9\s_\-!&.,;@:ò\/àèìù'"()]{5,100}$/;
    var err = ' Il titolo deve contenere da 5 a 100 caratteri alfanumerici e segni di punteggiatura ';
    return testRegex(regex, titolo, err);
}

function checkCorpo(corpo) {
    var err = "Inserire da 15 a 1000 caratteri alfanumerici e segni di punteggiatura";
    var regex = /^[a-zA-Z0-9\s_\-!&@.,;\/:òàèìù'"()]{15,1000}$/;

    return testRegex(regex, corpo, err);
}

function checkImmagine(immagine) {

    var regex = /^([a-zA-Zàèìòù\s.-_]{0,45}\.(jpg|jpeg))?$/;
    var err = "L'immagine deve essere in formato .jpg o .jpeg e con nome privo di caratteri speciali eccetto . - _ e spazi bianchi ";

    return testRegex(regex, immagine, err);
}

function checkImmaginePianta(immagine) {

    var regex = /^([a-zA-Zàèìòù\s.-_]{1,45}\.(jpg|jpeg))?$/;
    var err = "L'immagine deve essere in formato .jpg o .jpeg e con nome privo di caratteri speciali eccetto . - _ e spazi bianchi ";

    return testRegex(regex, immagine, err);
}

function checkData(mese, giorno) {
    var mese = document.getElementById(mese);
    var giorno = document.getElementById(giorno);
    var padre = giorno.parentElement;
    giorno = giorno.options[giorno.selectedIndex].value;
    mese = mese.options[mese.selectedIndex].value;
    var mesiTrenta = ['04','06','09','11'];
    if ((giorno>=29 && mese==02) || (giorno>=31 && mesiTrenta.indexOf(mese) != -1)) {
        var err = 'Data non valida';
        stampaErrore(padre, err);
        return false;
    }
    else {
       pulisciErrore(padre);
       return true;
    }
}

//Crea un tag STRONG che visualizza l'errore
function stampaErrore(elem, msg){

    if(elem.lastElementChild.tagName != "STRONG") {

        var e = document.createElement("strong");
        e.className = "errore";
        e.appendChild(document.createTextNode(msg));
        elem.appendChild(e);
    }
}

//Elimina un tag strong che visualizzava un vecchio errore
function pulisciErrore(elem){
    if(elem.lastElementChild.tagName == "STRONG")
           elem.removeChild(elem.lastElementChild);
}

function checkNomiPianta(nome){
  var regex = /^[a-zA-Z\s]{3,50}$/;
  var err = "Inserire da 3 a 50 caratteri alfabetici (solo lettere)";
  return testRegex(regex, nome, err);
}

function checkNomiAtt(nome){
  var regex = /^[a-zA-Z\s]{0,20}$/;
  var err = "Inserire max 20 caratteri alfabetici (solo lettere)";
  return testRegex(regex, nome, err);
}

function checkNumeriPianta(numero, max){
  if(!(numero.value >= 0 && numero.value <= max)){
      
    stampaErrore(numero.parentElement, "Inserire un numero compreso tra 0 e "+max);
    return false;
  }
  else{
    pulisciErrore(numero.parentElement);
    return true;
  }
}

function checkGruppo(gruppo){
  var disabilitati = document.querySelectorAll('#Fusto, #radice, #forma, #composizione, #margine, #superficie, #nome, #colore, #colore_fr, #nome_fr, #num_petali');
  if(gruppo.value == "A" || gruppo.value == "B"){
    for(var i=0; i<disabilitati.length; i++){
      disabilitati[i].disabled = true;
    }
  }
  else {
      if(gruppo.value != "TSA")
        for(var i=6; i<disabilitati.length; i++)
            disabilitati[i].disabled = true;
      else
          for(var i=0; i<disabilitati.length; i++)
            disabilitati[i].disabled = false;
  }
}




/* funzioni per controllare che almeno un checkbox per ogni gruppo (tranne principi) sia checked */

function controllaChecks(){
    var boxUtilizzo = document.querySelectorAll("[name='Utilizzo[]']");
    var boxBioma =  document.querySelectorAll("[name='BiomaA[]'], [name='BiomaT[]']");
    var boxStato = document.querySelectorAll("[name='Stato[]']");

    var errore = false;
    var disp = " ";

   if(!controllaCheck(boxUtilizzo)){
    errore = true;
    disp = "Seleziona almeno un utilizzo";
   }

   if(!controllaCheck(boxBioma) && !errore){
    errore = true;
    disp = "Seleziona almeno un bioma";
  }

   if(!controllaCheck(boxStato) && !errore){
    errore = true;
    disp = "Seleziona almeno uno stato";
   }

  if(errore){
    alert(disp);
    return false;
  }
}

function controllaCheck(insiemebox){

  var almenouno = false;
  for(var i=0; i<insiemebox.length && !almenouno; i++){
    if(insiemebox[i].checked){
      almenouno = true;
    }
  }
  return almenouno;
}

/*fine funzioni checkbox */
