<?php

	# SOAP REPORTES

	$operacion = $_GET["operacion"];
	
    try{
        //$wsdl_url = 'http://localhost:1515/ws/reportes?wsdl';
		//$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/reportes?wsdl';
		$wsdl_url = 'https://gestion-academica-soap.herokuapp.com/reportes?wsdl';
		
        $soapClient = new SOAPClient($wsdl_url);
		
		# OPERACION traerHistorialAcademicoPorEstudiante
		if($operacion == "traerHistorialAcademicoPorEstudiante"){
			
			$idUsuario = $_GET["idUsuario"];
			
			$parametros = array(
				'idUsuario' => $idUsuario
			);

			$estudianteWS = $soapClient->traerEstudianteConCarrera($parametros);
			$historialAcademicoWS = $soapClient->traerHistorialAcademicoPorEstudiante($parametros);
			
			if( (isset($estudianteWS->{'return'})) && (isset($historialAcademicoWS->{'return'})) ){
				$estudiante = $estudianteWS->{'return'};
				$historialAcademicoList = $historialAcademicoWS->{'return'};
				require_once('acciones/generarAnaliticoEstudiantePDF.php');
			}
			else{
				$params = array(
					'mensaje' => 'El estudiante no existe o no posee historial academico',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}

		}
		# OPERACION traerComisionesPorInscripcionYCarreraYTurno
		elseif($operacion == "traerComisionesPorInscripcionYCarreraYTurno"){
	
			$idInscripcion = $_GET["idInscripcion"];
			$idCarrera = $_GET["idCarrera"];
			$idTurno = $_GET["idTurno"];

			$data = null;
			
			$parametros = array(
				'idInscripcion' => $idInscripcion,
				'idCarrera' => $idCarrera,
				'idTurno' => $idTurno
			);

			$materiaWS = $soapClient->traerComisionesPorInscripcionYCarreraYTurno($parametros);
			$cabeceraPlanillaMaterias = $soapClient->traerCabeceraPlanillaMaterias($parametros);
			
			if( (isset($materiaWS->{'return'})) && (isset($materiaWS->{'return'})) ){
				$materiasList = $materiaWS->{'return'};
				$cabecera = $cabeceraPlanillaMaterias->{'return'};
				require_once('acciones/generarPlanillaMateriasPDF.php');
			}
			else{
				$params = array(
					'mensaje' => 'No existen materias asociadas para la carrera y turno solicitado',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}
			
		}
		# OPERACION traerEstudiantesPorComision
		elseif($operacion == "traerEstudiantesPorComision"){
	
			$idComision = $_GET["idComision"];
			
			$parametros = array(
				'idComision' => $idComision
			);

			$estudiantesWS = $soapClient->traerInscripcionesPorComision($parametros);
			$cabeceraPlanillaEstudiantes = $soapClient->traerCabeceraPlanillaEstudiantes($parametros);
			
			if( (isset($estudiantesWS->{'return'})) && (isset($cabeceraPlanillaEstudiantes->{'return'})) ){
				$estudiantesList = $estudiantesWS->{'return'};
				$cabecera = $cabeceraPlanillaEstudiantes->{'return'};
				require_once('acciones/generarListadoInscriptosExcel.php');
			}
			else{
				$params = array(
					'mensaje' => 'No existen estudiantes asociados para la comision solicitada',
				);
				header("Content-Type: application/json");
				echo json_encode($params);
			}

		}

		
    }
    catch(Exception $ex){
        echo "Exception ocurred: " . $ex;
    }

?>