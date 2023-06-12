'use restrict'



// event.preventDefault()
//cogemos los campos del formulario
let nombre = document.forms['signup-form']['nombre'];
let apellido1 = document.forms['signup-form']['apellido1'];
let apellido2 = document.forms['signup-form']['apellido2'];
let email = document.forms['signup-form']['email'];
let dni = document.forms['signup-form']['dni'];
let iban = document.forms['signup-form']['iban'];
let contraseña = document.forms['signup-form']['contraseña'];
let rep_contraseña = document.forms['signup-form']['rep_contraseña'];
let foto = document.forms['signup-form']['foto'];
let boton = document.forms['signup-form']['submit'];

//boolean validado
let validado = true

//regx
//sin numeros
const RegxNum = /^([^0-9]*)$/

//al menos un numero o letra, una @, otro numero o letra, un punto y luego minimo dos letras
const RegxEmail = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/

//8 dijitos y una letra
const RegxDNI = /^\d{8}[a-zA-Z]{1}$/

//2 letras y 22 numeros
const RegxIBAN = /^[a-zA-Z]{2}[0-9]{22}$/

//minimo 8 caracteres, maximo 15, al menos una mayuscula, una minuscula, un digito, un caracter especial y sin espacios
const RegxPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}$/

//validación de formulario

//contraseña
contraseña.addEventListener('change', function () {
    if (!RegxPass.test(contraseña.value)) {
        contraseña.classList.add('invalid')
        validado = false
    } else {
        contraseña.classList.remove('invalid')
        validado = true
    }
});

//nombre
nombre.addEventListener('change', function () {
    console.log(nombre.value)
    if (nombre.value.length <= 3 || !RegxNum.test(nombre.value)) {
        nombre.classList.add('invalid')
        validado = false
    } else {
        nombre.classList.remove('invalid')
        validado = true
    }
});

//1º apellido
apellido1.addEventListener('change', function () {
    if (apellido1.value.length <= 3 || !RegxNum.test(apellido1.value)) {
        apellido1.classList.add('invalid')
        validado = false
    } else {
        apellido1.classList.remove('invalid')
        validado = true
    }
});

//2º apellido
apellido2.addEventListener('change', function () {
    if (apellido2.value.length <= 3 || !RegxNum.test(apellido2.value)) {
        apellido2.classList.add('invalid')
        validado = false
    } else {
        apellido2.classList.remove('invalid')
        validado = true
    }
});

//email
email.addEventListener('change', function () {
    if (!RegxEmail.test(email.value)) {
        email.classList.add('invalid')
        validado = false
    } else {
        email.classList.remove('invalid')
        validado = true
    }
});

//dni
dni.addEventListener('change', function () {
    if (!RegxDNI.test(dni.value)) {
        dni.classList.add('invalid')
        validado = false
    } else {
        dni.classList.remove('invalid')
        validado = true
    }
});

//iban
iban.addEventListener('change', function () {
    if (!RegxIBAN.test(iban.value)) {
        iban.classList.add('invalid')
        validado = false
    } else {
        iban.classList.remove('invalid')
        validado = true
    }
});

//contraseña
contraseña.addEventListener('change', function () {
    if (!RegxPass.test(contraseña.value)) {
        contraseña.classList.add('invalid')
        validado = false
    } else {
        contraseña.classList.remove('invalid')
        validado = true
    }
});

//rep contraseña
iban.addEventListener('change', function () {
    if (contraseña.value != rep_contraseña.value) {
        rep_contraseña.classList.add('invalid')
        validado = false
    } else {
        rep_contraseña.classList.remove('invalid')
        validado = true
    }
});

//foto
foto.addEventListener('change', function() {
    if (!foto.value.includes('.png') || !foto.value.includes('.jpg')) {
        foto.classList.add('invalid')
        validado = false
    } else {
        foto.classList.remove('invalid')
        validado = true
    }
})

//habilitamos el botón de registrar si todo está validado
if (validado) {
    boton.disabled = false;
}