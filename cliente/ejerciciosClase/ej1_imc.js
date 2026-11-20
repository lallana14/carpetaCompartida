function calcularIMC(peso, altura) {
    if (altura <= 0 || peso <= 0) {
        alert("Algún dato ingresado es incorrecto, por favor verifique los datos");
    }else{
        return peso / (altura * altura);
    }
}

function mostrarResultado(imc) {
    if (imc < 18.5) {
        alert("Su IMC es: " + imc.toFixed(2) + " \nSu estado es: Bajo peso");
    }
    else if (imc >= 18.5 && imc < 25) {
        alert("Su IMC es: " + imc.toFixed(2) + "\nSu estado es: Peso normal");
    }
    else if (imc >= 25 && imc < 30) {
        alert("Su IMC es: " + imc.toFixed(2) + "\nSu estado es: Sobrepeso");
    }
    else {
        alert("Su IMC es: " + imc.toFixed(2) + "\nSu estado es: Obesidad");
    }
}
