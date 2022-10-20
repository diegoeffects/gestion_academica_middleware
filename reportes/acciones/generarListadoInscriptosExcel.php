<?php

/*
** reportes/acciones/generarListadoInscriptosExcel.php
**
** GENERAR EXCEL CON LOS ESTUDIANTES INSCRIPTOS EN UNA MATERIA
**
*/

    # ARCHIVO EXCEL

    $archivoExcel = fopen('../reportes/archivos/listadoInscriptos.csv', 'w');

    fputs($archivoExcel, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    $estado = $estudiantesInscriptos->{'estado'};

    if($estado == "EMPTY"){
        fputs($archivoExcel, "" . PHP_EOL);
    }

    if($estudiantesInscriptos->{'idInstancia'} == 1){

        fputs($archivoExcel, "Orden;Apellido;Nombre;DNI;Parcial 1;Parcial 2;Parcial 3;Rec. 1;Rec. 2;Rec. 3;TP1;TP2;TP3;Nota Cursada" . PHP_EOL);

        if(isset($estudiantesInscriptos->{'estudiantesInscriptos'})){

            if(is_array($estudiantesInscriptos->{'estudiantesInscriptos'})){

                $estudiantesInscriptosList = $estudiantesInscriptos->{'estudiantesInscriptos'};
            
                foreach ($estudiantesInscriptosList as $estudianteInscripto) {
            
                    $estudianteString = $estudianteInscripto->{'orden'} . ";" . $estudianteInscripto->{'apellido'} . ";" . $estudianteInscripto->{'nombre'} . ";" . $estudianteInscripto->{'dni'} . ";" . $estudianteInscripto->{'primerParcial'} . ";" . $estudianteInscripto->{'segundoParcial'} . ";" . $estudianteInscripto->{'tercerParcial'} . ";" . $estudianteInscripto->{'primerRecuperatorio'} . ";" . $estudianteInscripto->{'segundoRecuperatorio'} . ";" . $estudianteInscripto->{'tercerRecuperatorio'} . ";" . $estudianteInscripto->{'tp1'} . ";" . $estudianteInscripto->{'tp2'} . ";" . $estudianteInscripto->{'tp3'}
                    . ";" . $estudianteInscripto->{'notaCursada'};
            
                    fwrite($archivoExcel, $estudianteString . PHP_EOL);
            
                }

            }
            else{

                $estudianteInscripto= $estudiantesInscriptos->{'estudiantesInscriptos'};

                $estudianteString = $estudianteInscripto->{'orden'} . ";" . $estudianteInscripto->{'apellido'} . ";" . $estudianteInscripto->{'nombre'} . ";" . $estudianteInscripto->{'dni'} . ";" . $estudianteInscripto->{'primerParcial'} . ";" . $estudianteInscripto->{'segundoParcial'} . ";" . $estudianteInscripto->{'tercerParcial'} . ";" . $estudianteInscripto->{'primerRecuperatorio'} . ";" . $estudianteInscripto->{'segundoRecuperatorio'} . ";" . $estudianteInscripto->{'tercerRecuperatorio'} . ";" . $estudianteInscripto->{'tp1'} . ";" . $estudianteInscripto->{'tp2'} . ";" . $estudianteInscripto->{'tp3'}
                . ";" . $estudianteInscripto->{'notaCursada'};
        
                fwrite($archivoExcel, $estudianteString . PHP_EOL);

            }

        }

    }
    elseif($estudiantesInscriptos->{'idInstancia'} == 2){

        fputs($archivoExcel, "Orden;Apellido;Nombre;DNI;Nota Cursada;Nota Final;Nota Definitiva" . PHP_EOL);

        if(isset($estudiantesInscriptos->{'estudiantesInscriptos'})){

            if(is_array($estudiantesInscriptos->{'estudiantesInscriptos'})){

                $estudiantesInscriptosList = $estudiantesInscriptos->{'estudiantesInscriptos'};
            
                foreach ($estudiantesInscriptosList as $estudianteInscripto) {
        
                    $estudianteString = $estudianteInscripto->{'orden'} . ";" . $estudianteInscripto->{'apellido'} . ";" . $estudianteInscripto->{'nombre'} . ";" . $estudianteInscripto->{'dni'} . ";" . $estudianteInscripto->{'notaCursada'} . ";" . $estudianteInscripto->{'notaFinal'} . ";" . $estudianteInscripto->{'notaDefinitiva'};
            
                    fwrite($archivoExcel, $estudianteString . PHP_EOL);
                }
            
            }
            else{

                $estudianteInscripto= $estudiantesInscriptos->{'estudiantesInscriptos'};

                $estudianteString = $estudianteInscripto->{'orden'} . ";" . $estudianteInscripto->{'apellido'} . ";" . $estudianteInscripto->{'nombre'} . ";" . $estudianteInscripto->{'dni'} . ";" . $estudianteInscripto->{'notaCursada'} . ";" . $estudianteInscripto->{'notaFinal'} . ";" . $estudianteInscripto->{'notaDefinitiva'};
            
                fwrite($archivoExcel, $estudianteString . PHP_EOL);

            }

        }

    }

    fclose($archivoExcel);

    $url = "../reportes/archivos/listadoInscriptos.csv";
    
    header("Location: $url");

?>