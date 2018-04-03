var id = "intestatario";
var regex = /^[a-zA-Zàèìòù\s]{5,50}$/;
var err = ["Intestatario non valido. Usare solo lettere maiuscole e minuscole, minimo 5 caratteri, massimo 50", "Data non valida"];
var mesiTrenta = ['04', '06', '09', '11'];

function valPrenotazione() {
    window.scrollTo(0,0);
    return check() && checkData();
}

function check() {
    
    var input = document.getElementById(id);
    
    if(input.value.search(regex) == -1) {
        
        stampaErrore(input.parentElement, err[0]);
        return false;
    }
    else {
        pulisciErrore(input.parentElement);         
        return true;
    }
}

function checkData() {
    
    var giorno = document.getElementById("giorno");
    var padre = giorno.parentElement; 
    var mese = document.getElementById("mese");
    
    giorno = giorno.options[giorno.selectedIndex].value;
    mese = mese.options[mese.selectedIndex].value;
    
    if ((giorno>=29 && mese==02) || (giorno>=31 && mesiTrenta.indexOf(mese) != -1)) { 
        stampaErrore(padre, err[1]); 
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