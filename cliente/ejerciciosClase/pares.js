// Comprobar si un número es par
    function esPar(numero){
        if(numero % 2 == 0){//si al dividir por 2 el resto es 0 => es par
            return true;//devolvemos true poruqe el nombre de la funcion seria verdadero
        }else{
            return false;//devolvemos false porque el nombre de la funcion ya no seria verdadero
        }
    }
    

//muestra numeros pares/immpares entre A y B (dados)
    function numerosParesImpares(inicio, fin, tipo){
        let cadena = "";//creamos una cadena vacía
        if(tipo=="par"){//si es par
            document.write("Numeros pares del "+inicio+" al "+fin+":<br>");
            while(inicio<=fin){//bucle para ir desde inicio hasta fin
                if(esPar(inicio)){//si el numero es par entra
                    cadena += inicio + " ";//concatenamos los pares
                }
                inicio++;//sumamos al contador
            }
        }else if(tipo=="impar"){//si es impar
            document.write("Numeros impares del "+inicio+" al "+fin+":<br>");
            while(inicio<=fin){//bucle para ir de inicio hasta fin
                if(!esPar(inicio)){//si es numero no es par entra
                    cadena += inicio + " ";//concatenamos los impares
                }
                inicio++;//sumamos al contador
            }
        }else{//si el tipo no coincide con par ni impar
            document.write("Tipo no válido");//mostramos por pantalla codigo de error
        }
        
        return cadena;//devolvemos cadena (modificada) si tipo =="par" o =="impar"
    }


//Mario Lallana Campos
//IES Virgen del Espino
//DAW 2 - 2026/27