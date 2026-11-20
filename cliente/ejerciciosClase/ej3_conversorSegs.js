function horasASegundos(horas) {
    let segundos = horas * 3600;
    return segundos;
}

function minutosASegundos(minutos) {
    let segundos = minutos * 60;
    return segundos;
}

function convertirATotalSegundos(horas, minutos, segundos) {
    let totalSegundos = horasASegundos(horas) + minutosASegundos(minutos) + segundos;
    return totalSegundos;
}