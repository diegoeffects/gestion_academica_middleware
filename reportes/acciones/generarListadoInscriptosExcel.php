<?php

/*
** gestion/acciones/generarExcelListadoInscriptos.php
**
** GENERAR EXCEL CON LOS ESTUDIANTES INSCRIPTOS EN UNA COMISION
**
*/

    # ARCHIVO EXCEL

    $archivoExcel = fopen('../reportes/archivos/listadoInscriptos.csv', 'w');

    fputs($archivoExcel, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    if($cabecera->{'idInstancia'} == 1){

        fputs($archivoExcel, "Orden;Apellido;Nombre;DNI;Parcial 1;Parcial 2;Parcial 3;Rec. 1;Rec. 2;Rec. 3;TP1;TP2;TP3;Nota Cursada" . PHP_EOL);

        foreach ($estudiantesList as $estudiante) {
    
            $estudianteString = $estudiante->{'orden'} . ";" . $estudiante->{'apellido'} . ";" . $estudiante->{'nombre'}
            . ";" . $estudiante->{'dni'} . ";" . $estudiante->{'primerParcial'} . ";" . $estudiante->{'segundoParcial'} . ";" . $estudiante->{'tercerParcial'} . ";" . $estudiante->{'primerRecuperatorio'} . ";" . $estudiante->{'segundoRecuperatorio'} . ";" . $estudiante->{'tercerRecuperatorio'} . ";" . $estudiante->{'tp1'} . ";" . $estudiante->{'tp2'} . ";" . $estudiante->{'tp3'}
            . ";" . $estudiante->{'notaCursada'};
    
            fwrite($archivoExcel, $estudianteString . PHP_EOL);
    
        }

    }
    elseif($cabecera->{'idInstancia'} == 2){

        fputs($archivoExcel, "Orden;Apellido;Nombre;DNI;Nota Cursada;Nota Final;Nota Definitiva" . PHP_EOL);

        foreach ($estudiantesList as $estudiante) {
    
            $estudianteString = $estudiante->{'orden'} . ";" . $estudiante->{'apellido'} . ";" . $estudiante->{'nombre'}
            . ";" . $estudiante->{'dni'} . ";" . $estudiante->{'notaCursada'} . ";" . $estudiante->{'notaFinal'} . ";" . $estudiante->{'notaDefinitiva'};
    
            fwrite($archivoExcel, $estudianteString . PHP_EOL);
    
        }

    }

    fclose($archivoExcel);

    $url = "../reportes/archivos/listadoInscriptos.csv";
    
    header("Location: $url");

?>