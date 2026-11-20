//concat: de dos aarays
function juntarDosArrays(array1, array2){
    let total = [];//array donde se guardará el resultado
    let longTotal = array1.length + array2.length;//longitud del array total
    total = array1;//copia el primer array
    let j = 0;
    for(i=array1.length; i<longTotal; i++){//recorre el array total desde la posición del primer array hasta la longitud total
        total[i] = array2[j];//añade el elemento del segundo array al total
        j++;//incrementa el contador del segundo array
    }
    return total;
}

//concat: junta varios arrays
function juntarArrays(...arrays){
    let total = [];//array donde se guardará el resultado
    for(i=0; i<arrays.length; i++){//recorre los arrays que se le pasan
        for(j=0; j<arrays[i].length; j++){//recorre los elementos de cada array
            //total.push(arrays[i][j]);
            total[total.length] = arrays[i][j];//añade el elemento al array total
        }
    }
    return total;
}

//slice: pasando dos posicines
function cogeUnCacho(array, posInicial, posFinal){
    let copia = [];//array donde se guardará el resultado
    j = 0;
    if(posInicial>array.length-1 || posFinal>array.length-1){//compruebo si las posiciones son mayores que la longitud del array
        console.log("La posición es mayor que la longitud del array");
        return copia;
    }
    //compruebo si las posiciones son negativas; si lo son, las convierto a positivas
    if(posInicial<0){
        posInicial = array.length + posInicial;
    }
    if(posFinal<0){
        posFinal = array.length + posFinal;
    }
    for(i=posInicial; i<posFinal; i++){//recorre el array desde la poscion inicial hasta la final
        copia [j] = array[i];//añade el elemento a la copia
        j++;//incrementa el contador de la copia
    }
    return copia;
}

//slice: pasando una posicion
function cogeUnCacho(array, posInicial){
    let copia = [];//array donde se guardará el resultado
    j = 0;
    if(posInicial>array.length-1){//compruebo si la posición es mayor que la longitud del array
        console.log("La posición es mayor que la longitud del array");
        return copia;
    }
    //compruebo si la posición es negativa; si lo es, la convierto a positiva
    if(posInicial<0){
        posInicial = array.length + posInicial;
    }
    for(i=posInicial; i< array.length; i++){//recorre el array desde la poscion inicial hasta el final
        copia[j] = array[i];//añade el elemento a la copia
        j++;//incrementa el contador de la copia
    }
    return copia;
}

//splice sin push:
function modificar(array, posicion, cantBorrar, ...elems){
    let tamañoInicial = array.length;//guarda la longitud del array original
    let copia = [];//array donde se guardará el resultado
    if(posicion<=tamañoInicial-1){
        if(cantBorrar<=tamañoInicial-posicion){
            for(i=0; i<tamañoInicial; i++){//recorre el array original
                if(i==posicion){//si la posicion es igual
                    for(j=0; j<elems.length; j++){//recorre los elementos
                        //copia.push(elems[j]);
                        copia[copia.length] = elems[j];//los añade a la copia
                    }
                    i += cantBorrar;//salta los elementos quetiene que borrar
                }
                //copia.push(elems[j]);
                copia[copia.length] = array[i];//añade el elemento del array original a la copia
            }
            return copia;
        }else{
            console.log("La cantidad a borrar es mayor que la longitud del array");
        }
    }else{
        console.log("La posición es mayor que la longitud del array");
    }
}