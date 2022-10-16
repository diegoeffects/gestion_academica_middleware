<?php

/*
** gestion/acciones/generarExcel.php
**
** GENERAR EXCEL CON CONVOCATORIAS
**
*/

	# CARGA DE CONFIGURACION

	include("config.php");

    # SI INGRESAN A ESTE CONTROLADOR DE FORMA DIRECTA LOS REDIRIGE AL INICIO
    if( !isset($_POST["token"]) ){
        $url = "../index.php";
        header("Location: $url");
    } // end_if
    else{

        # VARIABLES

        $convocatorias = array();

        $query = "";
        $in_ic = "";
        $types = "";

        # TRAER CONVOCATORIAS

        $query = "SELECT c.idConvocatoria, c.denominacion, c.descripcion, p.nombre AS pais, m.modalidad, c.requisitos,
        c.financiamiento, c.beneficios,
        GROUP_CONCAT(DISTINCT ate.areaTematica SEPARATOR ', ') AS areasTematicas,
        GROUP_CONCAT(DISTINCT d.destinatario SEPARATOR ', ') AS destinatarios,
        GROUP_CONCAT(DISTINCT i.institucion SEPARATOR ', ') AS instituciones,
        GROUP_CONCAT(DISTINCT t.tipo SEPARATOR ', ') AS tiposConvocatoria,
        GROUP_CONCAT(DISTINCT pcc.palabraClave SEPARATOR ', ') AS palabrasClave,
        DATE_FORMAT(fechaCierre, '%d/%m/%Y') AS fechaCierre,
        CASE WHEN c.tieneFinanciamiento = 0 THEN 'No' ELSE 'Si' END,
        GROUP_CONCAT(DISTINCT ExtractValue(c.enlaces, '//text()') SEPARATOR ', ') AS enlaces
        FROM convocatorias c
        LEFT JOIN paises p ON p.idPais = c.idPais
        LEFT JOIN modalidades m ON m.idModalidad = c.idModalidad
        LEFT JOIN areas_tematicas_convocatoria atc ON atc.idConvocatoria=c.idConvocatoria
        LEFT JOIN areas_tematicas ate ON ate.idAreaTematica=atc.idAreaTematica
        LEFT JOIN destinatarios_convocatoria dc ON dc.idConvocatoria=c.idConvocatoria
        LEFT JOIN destinatarios d ON d.idDestinatario=dc.idDestinatario
        LEFT JOIN instituciones_convocatoria ic ON ic.idConvocatoria=c.idConvocatoria
        LEFT JOIN instituciones i ON i.idInstitucion=ic.idInstitucion
        LEFT JOIN tipos_convocatoria tc ON tc.idConvocatoria=c.idConvocatoria
        LEFT JOIN tipos t ON t.idTipo=tc.idTipo
        LEFT JOIN palabras_clave_convocatoria pcc ON pcc.idConvocatoria=c.idConvocatoria";
        
        $identificadoresConvocatorias = $_POST["convocatorias"];

        $identificadoresConvocatorias = unserialize($identificadoresConvocatorias);

        $in_ic  = str_repeat('?,', count($identificadoresConvocatorias) - 1) . '?';
        $query = $query . " WHERE c.idConvocatoria IN ($in_ic) ";
        $types = $types . str_repeat('i', count($identificadoresConvocatorias));

        $query = $query . ' GROUP BY c.idConvocatoria ';
        $stmt = $conexion->prepare($query);

        $stmt->bind_param($types, ...$identificadoresConvocatorias);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        #########################################
        # ARCHIVO EXCEL
        #########################################

        $archivoExcel = fopen('../archivos/convocatorias.csv', 'w');

        fputs($archivoExcel, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        fputs($archivoExcel, "Identificador;Denominación;Descripción;País;Modalidad;Requisitos;Financiamiento;Beneficios;Áreas temáticas;Destinatarios;Instituciones;Tipo de convocatoria;Palabras clave;Fecha de cierre;Financiamiento externo;Enlaces" . PHP_EOL);

        # PROCESO RESULTADOS

        while($row = $result->fetch_assoc()) {

           fputcsv($archivoExcel, $row, ";");
        
        } // end_while
        
        fclose($archivoExcel);

        $url = "../archivos/convocatorias.csv";
        header("Location: $url");

        $htmldata = '<p><a href="https://www.unla.edu.ar" target="_blank" rel="noopener">Sitio oficial UNLa</a></p>

        <p><a href="http://www.unla.edu.ar/secretarias/cooperacion-y-servicio-publico/direccion-de-cooperacion-internacional/convocatorias" target="_blank" rel="noopener">Direcci&oacute;n de Cooperaci&oacute;n Internacional</a></p>';

        error_log(strip_tags($htmldata));

    } // end_else

    ?>