function mostrarDOM(elemento, array){
    document.getElementById(elemento).innerHTML="";
    for(let i=0;i<array.length;i++){
        document.getElementById(elemento).innerHTML += `<div>${array[i]}</div>`
    }
}

let numeros = [1,9,7,5,99];
console.log(numeros[0]);
console.log(numeros[numeros.length-1]);
console.log(numeros.at(2));
console.log(numeros.at(-1));
console.log(numeros.at(-2));

//inmutabilidad/mutabilidad

//METODOS MUTABLES 
let cervezas = ["mahou", "estrella", "alhambra"];
//push: añade al final 
cervezas.push("heineken");
//unshift: añade al principio
cervezas.unshift("aguila");
//splice: agrega elemento en cualquier posicion
//splice(indice_dnd_insertar, numeros_valores_borrar, elemento(s)_insertar)
cervezas.splice(2,0,"bud","x");
// console.log(cervezas);
cervezas.splice(3,1,"cruzcampo");
// console.log(cervezas);
//pop: elimina el ultimo elemento
cervezas.pop();
// console.log(cervezas);
//shift: elimina el primer elemento
cervezas.shift();
// console.log(cervezas);
//fill: rellena el array con un valor
//fill(valor, indice_inicio, indice_final)
// console.log(cervezas);
// cervezas.fill("desperados",0,cervezas.length-1);
// console.log(cervezas);


//METODOS INMUTABLES
let aguas = ["Monte pinos", "bio solan"];
//concat: concatena dos arrays, crea un nuevo array sin modificar la estructura de ninguno de los anteriores, el nuevo array es independiente
let bebidas = cervezas.concat(aguas);
//indexOf: busca el indice de un elemento, si lo encuentra te lo devuelve, si no devuelve -1

//slice: genera un nuevo array apartir de un grupo de valores
let cervezas2 = cervezas.slice(2);


//MOSTRAR CON FUNCION

// mostrarDOM("array1",cervezas);
// mostrarDOM("array2",aguas);
// mostrarDOM("array3",bebidas);

//SPREAD
//primer uso
let numeros2 = [1,2,3,4];


function suma(a,b,c,d){
    return a+b+c+d;
}

// console.log(suma(1,2,3,4));
// console.log(suma(numeros[0],numeros[1],numeros[2],numeros[3]));
// console.log(suma(...numeros2));

//segundo uso
//concatenar arrays
let spreadArray = [...numeros2,...cervezas];
// mostrarDOM("array1", spreadArray);
let spreadArray2 = [...numeros2, "silla", "mesa", ...cervezas];
// mostrarDOM("array2", spreadArray2);

//tercer uso
//copiar arrays
let copiaArray = numeros2;//puntero a numeros2, no crea otro array
// copiaArray[0] = 100;
// numeros2[1] = 300;
// mostrarDOM("array1", numeros2);
// mostrarDOM("array2", copiaArray);

copiaArray = [...numeros2];
copiaArray[0] = 100;
numeros2[1] = 300;
// mostrarDOM("array1", numeros2);
// mostrarDOM("array2", copiaArray);


//crear array de objetos
function Curso (nombre, horas, precio){
    this.nombre = nombre;
    this.horas = horas;
    this.precio = precio;
}

let c1 = new Curso("java",40,170);
let c2 = new Curso("html",12,150);
let c3 = new Curso("css",18,110);
let c4 = new Curso("python",20,80);
let c5 = new Curso("c++",32,125);

let arrayCursos = [c1,c2,c3,c4,c5];

// function mostrarDOM2(elemento, array){
//     document.getElementById(elemento).innerHTML="";
//     for(let i=0;i<array.length;i++){
//         document.getElementById(elemento).innerHTML += `<div>`;
//         for(let x in array[i]){
//             document.getElementById(elemento).innerHTML += `${array[i][x]} `;
//         }
//         document.getElementById(elemento).innerHTML += `</div>`;
//     }
// }

function mostrarDOM2(elemento, array){
    document.getElementById(elemento).innerHTML="";
    for(let i=0;i<array.length;i++){
        document.getElementById(elemento).innerHTML += `<div>Curso: ${array[i].nombre}, ${array[i].horas} horas, ${array[i].precio} €</div>`;
    }
}

mostrarDOM2("array1", arrayCursos);

//FUNCIONES DE PRIMER ORDEN
let fn = function(){
    console.log("hola");
}

//FUNCIONES DE ORDEN SUPERIOR
function ordenSuperior(funcion, nombre){
    console.log("Antes");
    funcion(nombre);
    console.log("Despues");

}

//FUNCIONES FLECHA/ARROW
//let nombreFuncion = (parametro1, ...) => {codigo_de_funcion}
let fnArrow = x => x*2;
let fnArrow2 = (x) => x+1;
let fnArrow3 = (a,b) => a+b;
let fnArrow4 = (a,b) => {
    if(a!=0){

    }
    return a+b;
};

let arrow = (nombre, texto) => {
    console.log(`Hola ${nombre} ${texto}`);
};

ordenSuperior(arrow,"Pepe");
arrow("pepe", "buenas noches");

//FOR ... OF para objetos iterables(array, map, set, string)
for(let e of arrayCursos){
    console.log(`${e.nombre} ${e.horas} ${e.precio}`);
}

//FOREACH
arrayCursos.forEach((lenguaje, indice) => {
    console.log(lenguaje);
    console.log(`Indice ${indice}`);
});


//SORT funcion MUTABLE
let numerosDes = [888, 3, 23, 7, 67, 20, 90];
console.log(numerosDes.sort((a,b) => a-b));


//FALTA DIA 17-11
 // find: encontrar el PRIMER ELEMENTO que cumpla una condición.

let encontrado = lenguajesProg.find(elemento => elemento.nombre === "HTML");
console.log(encontrado);        
let encontrado1 = lenguajesProg.find(elemento => elemento.precio > 100);
console.log(encontrado1);        

// filter: igual que find pero devuelve TODOS los objetos que cumplan la condición.

let encontrado2 = lenguajesProg.filter(elemento => elemento.nombre === "HTML");
console.log(encontrado2);        
let encontrado3 = lenguajesProg.filter(elemento => elemento.precio > 100);
console.log(encontrado1);        

// every: que cada uno de los elementos cumpla una condición, si no cumple todos, devuelve true si TODOS devuelven la condición.
let funcionEvery = e => e.horas > 70;
console.log(lenguajesProg.every(funcionEvery));

// some: igual que every pero devuelve true con que UN ÚNICO ELEMENTO cumpla la condición.
let funcionSome = s => s.horas > 190;
console.log (lenguajesProg.some(funcionSome));


// reverse: (MUTABLE) invierte el orden de los elementos de un array
let lenguajesInvertidos = [...lenguajesProg];

console.log(lenguajesInvertidos.reverse());
console.log(lenguajesProg);

// map: (INMUTABLE) recorre todos los elementos del array y aplica alguna operación.
// Tambien puede trasnformar un array.

let lenguajesProg2 = lenguajesProg.map(elemento  => {
    return {
        // SOLAMENTE ACTUALIZAMOS LAS HORAS
        nombre: elemento.nombre,
        horas: elemento.horas * 2,
        precio: elemento.precio
    };
});
console.log(lenguajesProg2);


let lenguajesProg3 = lenguajesProg.map(elemento  => {
    return {
        // UPDATE del valor HORAS
        horas: elemento.horas * 2
    };
});
console.log(lenguajesProg3);


let lenguajesProg4 = lenguajesProg.map(elemento  => {
    return elemento.horas *2;
});

console.log(lenguajesProg4);


// Devolver un sumatorio de todos los elementos de un array y devolvemos el número de horas totales.
//

// function acumularHoras (array){
// let contador = 0;
//     for (x of lenguajesProg){
//         contador = contador + elemento.horas;
//     }
//     return contador;
// };

// // console.log(acumularHoras(lenguajesProg));

// let contador = 0;
//     for (let x of lenguajesProg){
//        contador = contador + x.horas;
//     }
//        console.log(contador);

    
let contador = 0;
    lenguajesProg.forEach(x => {
        contador = contador + x.horas;
    });
        console.log(contador);


// reduce: recorre el array y te devuelve un único valor.
// Primer parámetro es el acumulador o contador en donde se aplica el cambio de los valores.
// Segundo parámetro son los valores específicos con el elemento a modificar.
// Tercer parámetro es la cifra inicial en donde comienza nuestro acumulador o contador.
    let sumaHoras = lenguajesProg.reduce((acumulador, valor) => acumulador + valor.horas, 0);
    console.log(sumaHoras);

    let cursos = lenguajesProg.reduce((acumulador, valor) => acumulador + " " + valor.nombre, "");
    console.log(cursos);
//FIN DIA 17-11

//ARRAY DE FUNCIONES
let arrayFunciones = [
    () => console.log("Primera funcion"),
    () => console.log("Segunda funcion"),
    () => console.log("Tercera funcion"),
    () => console.log("Cuarta funcion")
];

arrayFunciones.forEach(elemento => elemento()); 

//OBJETO SET: es una coleccion especial: "conjunto de valores sin claves", donde cada valor puede aparecer solo una vez

let repetidos = ["MADRID", "SORIA", "CUENCA", "LOGROÑO", "ZARAGOZA", "CUENCA", "LOGROÑO", "ZARAGOZA", "SORIA", "CUENCA"];
let sinRepetir = new Set(repetidos);
console.log(sinRepetir);
console.log(sinRepetir.size);

//convertir set a array
//1
let arrayDesdeSet = Array.from(sinRepetir);
console.log(arrayDesdeSet);
//2
let arrayDesdeSet2 = [...sinRepetir];
console.log(arrayDesdeSet2);

sinRepetir.add("TERUEL");
console.log(sinRepetir);

sinRepetir.add("TERUEL");
console.log(sinRepetir);

//clear() elimina todos los elemenotos del set
// sinRepetir.clear();
console.log(sinRepetir);

//delete() elimina el elemento
sinRepetir.delete("MADRID");
console.log(sinRepetir);

//has() si un elemento existe o no
console.log(sinRepetir.has("SORIA"));

//union
let a = new Set(['a', 'b', 'c']);
let b = new Set(['b', 'c', 'd']);

let c = a.union(b);
console.log(c);

let x = prompt("Introduzca un número: ");
console.log(x);
