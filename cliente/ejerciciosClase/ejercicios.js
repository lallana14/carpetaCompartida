function añadirFinal(array, elemento){
    let posicion = array.length;
    array [posicion] = elemento;
    return array;
}

function borrarUltimo(array){
    array.length = array.length - 1;
    return array;
}

function añadirPrincipio(array, elemento){
    for(i=array.length-1; i>=0; i--){
        array[i+1] = array[i]; 
    }
    array[0] = elemento;
    return array;
}

function borrarPrimero(array){
    for(i=1; i<=array.length-1; i++){
        array[i-1] = array[i];
    }
    array.length = array.length - 1;
    return array;
}