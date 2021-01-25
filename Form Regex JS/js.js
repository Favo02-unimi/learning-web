document.getElementById("submit").disabled = true;

function verificaInput(id, idPattern) {
  console.log("verifica elemento " + id);

  if (id == "password2") {
    var password1 = document.getElementById("password1");
    var password2 = document.getElementById("password2");
    console.log("prova");
    var errore = document.getElementById("errore");
    if (!(password1.value === password2.value)) {
      console.log("psw diverse");
      password2.classList.add("invalid");
      errore.innerHTML = "Le due password non corrispondono.";
      errore.style.visibility = "visible";
      document.getElementById("submit").disabled = true;
    }
    else {
      password2.classList.remove("invalid");
      errore.innerHTML = "";
      errore.style.visibility = "hidden";
      document.getElementById("submit").disabled = false;
    }
  }
  else {
    if (document.form.checkValidity()) {
      document.getElementById("submit").disabled = false;
    }
    else {
      document.getElementById("submit").disabled = true;
    }
  }
}
