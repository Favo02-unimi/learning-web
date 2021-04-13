//index.php
function toggleLogin() {
    document.getElementById("loginForm").classList.remove("hidden");
    document.getElementById("registrazioneForm").classList.add("hidden");

    document.getElementById("login").classList.add("active");
    document.getElementById("registrazione").classList.remove("active");
}

function toggleRegistazione() {
    document.getElementById("loginForm").classList.add("hidden");
    document.getElementById("registrazioneForm").classList.remove("hidden");

    document.getElementById("login").classList.remove("active");
    document.getElementById("registrazione").classList.add("active");
}

function toggleCheckbox() {
    if (document.getElementById("checkbox1").checked) {
        document.getElementById("proprietario1").classList.toggle("colorViola");
        document.getElementById("cliente1").classList.toggle("colorViola");
    }
    if (document.getElementById("checkbox2").checked) {
        document.getElementById("proprietario2").classList.toggle("colorViola");
        document.getElementById("cliente2").classList.toggle("colorViola");
    }
}

//proprietario.php
function toggleAggiungiAppartamento() {
    document.getElementById("aggiungiAppartamentoTitolo").classList.toggle("hidden");
    document.getElementById("aggiungiAppartamentoForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("rimuoviAppartamentoTitolo").classList.add("hidden");
    document.getElementById("rimuoviAppartamentoForm").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaForm").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaForm").classList.add("hidden");
}

function toggleRimuoviAppartamento() {
    document.getElementById("rimuoviAppartamentoTitolo").classList.toggle("hidden");
    document.getElementById("rimuoviAppartamentoForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("aggiungiAppartamentoTitolo").classList.add("hidden");
    document.getElementById("aggiungiAppartamentoForm").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaForm").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaForm").classList.add("hidden");
}

function toggleDisponibilita() {
    document.getElementById("aggiungiDisponibilitaTitolo").classList.toggle("hidden");
    document.getElementById("aggiungiDisponibilitaForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("aggiungiAppartamentoTitolo").classList.add("hidden");
    document.getElementById("aggiungiAppartamentoForm").classList.add("hidden");
    document.getElementById("rimuoviAppartamentoTitolo").classList.add("hidden");
    document.getElementById("rimuoviAppartamentoForm").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("rimuoviDisponibilitaForm").classList.add("hidden");
}

function toggleRimuoviDisponibilita() {
    document.getElementById("rimuoviDisponibilitaTitolo").classList.toggle("hidden");
    document.getElementById("rimuoviDisponibilitaForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("aggiungiAppartamentoTitolo").classList.add("hidden");
    document.getElementById("aggiungiAppartamentoForm").classList.add("hidden");
    document.getElementById("rimuoviAppartamentoTitolo").classList.add("hidden");
    document.getElementById("rimuoviAppartamentoForm").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaTitolo").classList.add("hidden");
    document.getElementById("aggiungiDisponibilitaForm").classList.add("hidden");
}

function changeToggledDisponibilita(id) {
    document.getElementById("idDisponibilita").value = id;
}

//cliente.php
function toggleAggiungiPrenotazione() {
    document.getElementById("aggiungiPrenotazioneTitolo").classList.toggle("hidden");
    document.getElementById("aggiungiPrenotazioneForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("rimuoviPrenotazioneTitolo").classList.add("hidden");
    document.getElementById("rimuoviPrenotazioneForm").classList.add("hidden");
}

function toggleRimuoviPrenotazione() {
    document.getElementById("rimuoviPrenotazioneTitolo").classList.toggle("hidden");
    document.getElementById("rimuoviPrenotazioneForm").classList.toggle("hidden");

    //disattivo gli altri form in caso siano attivi
    document.getElementById("aggiungiPrenotazioneTitolo").classList.add("hidden");
    document.getElementById("aggiungiPrenotazioneForm").classList.add("hidden");
}

function changeToggledPrenotazione(id) {
    document.getElementById("idPrenotazione").value = id;
}

//cliente e proprietario
function changeToggled(id) {
    document.getElementById("id").value = id;
    var temp = document.getElementById("id2");
    if (typeof(temp) != 'undefined' && temp != null) {
        document.getElementById("id2").value = id;
    }
}
