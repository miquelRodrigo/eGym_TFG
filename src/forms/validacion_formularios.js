"use strict";

window.addEventListener(
  "load",
  function () {
    var form = document.getElementById("frmEmail");
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          validacionEmailForm();
        }
        form.classList.add("was-validated");
      },
      false
    );
  },
  false
);

window.addEventListener(
  "load",
  function () {
    var form = document.getElementById("frmRegister");
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          validacionRegistroForm();
        }
        form.classList.add("was-validated");
      },
      false
    );
  },
  false
);

window.addEventListener(
  "load",
  function () {
    var form = document.getElementById("frmLogin");
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          validacionLoginForm();
        }
        form.classList.add("was-validated");
      },
      false
    );
  },
  false
);

window.addEventListener(
  "load",
  function () {
    var form = document.getElementById("frmCalculadora");
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
          validacionCalculadoraForm();
        }
        form.classList.add("was-validated");
      },
      false
    );
  },
  false
);

function validacionEmailForm() {
  const emailRegex =
    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  const email = document.getElementById("email").value;

  if (email == "") {
    esInvalido("email", "Se debe introducir un email.");
  } else if (!emailRegex.test(email)) {
    esInvalido("email", "El email no es válido.");
  } else {
    esValido("email");
  }
}

function validacionRegistroForm() {
  const DNIRegex = /^\d{8}[a-zA-Z]{1}$/;

  const passRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$/;

  const pass = document.getElementById("pass").value.trim();
  const passRep = document.getElementById("passRep").value.trim();
  const nombre = document.getElementById("nombre").value.trim();
  const apellido1 = document.getElementById("apellido1").value.trim();
  const apellido2 = document.getElementById("apellido2").value.trim();
  const dni = document.getElementById("dni").value.trim();
  const imgUsuario = document.getElementById("imgUsuario").value.trim();

  if (pass == "") {
    esInvalido("pass", "Se debe introducir una contraseña.");
  } else if (!passRegex.test(pass)) {
    esInvalido(
      "pass",
      "La contraseña debe tener minúsculas, mayúsculas, al menos un número, un caracter especial y de 8 a 12 carácteres."
    );
  } else if (pass !== passRep) {
    esInvalido("pass", "Las contraseñas no son iguales.");
  } else {
    esValido("pass");
  }

  if (passRep == "") {
    esInvalido("passRep", "Se debe repetir la contraseña.");
  } else if (!passRegex.test(passRep)) {
    esInvalido(
      "passRep",
      "La contraseña debe tener minúsculas, mayúsculas, al menos un número, un caracter especial y de 8 a 12 carácteres."
    );
  } else if (passRep !== pass) {
    esInvalido("passRep", "Las contraseñas no son iguales.");
  } else {
    esValido("passRep");
  }

  if (nombre == "") {
    esInvalido("nombre", "Se debe introducir un nombre.");
  } else {
    esValido("nombre");
  }

  if (apellido1 == "") {
    esInvalido("apellido1", "Se debe introducir un primer apellido.");
  } else {
    esValido("apellido1");
  }

  if (apellido2 == "") {
    esInvalido("apellido2", "Se debe introducir un segundo apellido.");
  } else {
    esValido("apellido2");
  }

  if (dni == "") {
    esInvalido("dni", "Se debe introducir un DNI.");
  } else if (!DNIRegex.test(dni)) {
    esInvalido("dni", "El DNI no es válido.");
  } else {
    esValido("dni");
  }

  if (imgUsuario == "") {
    esInvalido("imgUsuario", "Se debe introducir una imagen para el usuario.");
  }
}

function validacionLoginForm() {
  const passRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$/;

  const pass = document.getElementById("passLogin").value.trim();

  if (pass == "") {
    esInvalido("passLogin", "Se debe introducir una contraseña.");
  } else if (!passRegex.test(pass)) {
    esInvalido(
      "passLogin",
      "La contraseña debe tener minúsculas, mayúsculas, al menos un número, un caracter especial y de 8 a 12 carácteres."
    );
  } else {
    esValido("passLogin");
  }
}

function validacionCalculadoraForm() {
  const sexo = Array.from(document.getElementsByName("sexoRadio"));
  const altura = document.getElementById("altura").value.trim();
  const peso = document.getElementById("peso").value.trim();
  const edad = document.getElementById("edad").value.trim();
  const factor = Array.from(document.getElementsByName("factorRadio"));

  if (sexo.every((item) => !item.checked)) {
    esInvalido("sexoRadio", "Se debe seleccionar un sexo.");
  } else {
    esValido("sexoRadio");
  }

  if (altura == "") {
    esInvalido("altura", "Se debe introducir una altura.");
  } else {
    esValido("altura");
  }

  if (peso == "") {
    esInvalido("peso", "Se debe introducir un peso.");
  } else {
    esValido("peso");
  }

  if (edad == "") {
    esInvalido("edad", "Se debe introducir una edad.");
  } else {
    esValido("edad");
  }

  if (factor.every((item) => !item.checked)) {
    esInvalido("factorRadio", "Se debe seleccionar un factor de actividad.");
  } else {
    esValido("factorRadio");
  }
}

function esValido(id) {
  document.getElementById(id + "-info").style.display = "none";
}

function esInvalido(id, texto) {
  document.getElementById(id + "-info").style.display = "inline";
  document.getElementById(id + "-info").innerText = texto;
}
