//fill
function rellenar(array, elemento){
    for(i=0; i<array.length; i++){
        array[i] = elemento;
    }
    return array;
}
//indexOf 
function primero(array,elemento){
    for(i=0; i<array.length; i++){
        if(array[i]==elemento){
            return i;
        }
    }
    return -1;
}
//lastIndexOf
function ultimo(array,elemento){
    for(i=array.length-1; i>=0; i--){
        if(array[i]==elemento){
            return i;
        }
    }
    return -1;
}
//indexOf
function primeroDesde(array, elemento, posicion){
    if(posicion<0){
        posicion = array.length + posicion;
    }
    if(posicion < array.length){
        for(i=posicion; i<array.length; i++){
            if(array[i]==elemento){
                return i;
            }
        }
    }
    return -1;
}
//lastIndexOf
function ultimoDesde(array, elemento, posicion){
    if(posicion<0){
        posicion = array.length + posicion;
    }
    if(posicion < array.length){
        for(i=posicion; i>=0; i--){
            if(array[i]==elemento){
                return i;
            }
        }
    }
    return -1;
}
//reverse
function alreves(array){
    let longTotal = array.length-1;
    let mitad = Math.floor(array.length/2);
    for(i=0; i<=mitad; i++){
        aux = array[i];
        array[i] = array[longTotal];
        array[longTotal] = aux;
        longTotal--;
    }
    return array;
}
//sort
function ordena(array){
    let todoNums = true;
    for(i=0; i<array.length; i++){
        if(typeof array[i] !== "number"){
            todoNums = false;
        }
    }
    if(todoNums){
        for(i=0; i<array.length-1; i++){
            for(j=i+1; j<array.length; j++){
                if(array[j]<=array[i]){
                    aux = array[i];
                    array[i] = array[j];
                    array[j] = aux;
                }
            }
        }
    }
    return array;
}