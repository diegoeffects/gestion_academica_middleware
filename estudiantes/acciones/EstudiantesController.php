<?php

    # REPORTES CONTROLLER

    //$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/estudiantes?wsdl';
    $wsdl_url = 'https://gestion-academica-soap.herokuapp.com/estudiantes?wsdl';

    try{

        $soapClientController = new SOAPClient($wsdl_url);

        function traerInscripcionesActivas(){
            global $soapClientController;
            return $soapClientController->traerInscripcionesActivas();
        }

        function traerInscripcionesPorEstudiante($parametros){
            global $soapClientController;
            return $soapClientController->traerInscripcionesPorEstudiante($parametros);
        }

        function traerMateriasPorInscripcionPorCarrera($parametros){
            global $soapClientController;
            return $soapClientController->traerMateriasPorInscripcionPorCarrera($parametros);
        }

        function altaInscripcionEstudiante($parametros){
            global $soapClientController;
            return $soapClientController->altaInscripcionEstudiante($parametros);
        }

        function bajaInscripcionEstudiante($parametros){
            global $soapClientController;
            return $soapClientController->bajaInscripcionEstudiante($parametros);
        }

        function actualizarDatosUsuario($parametros){
            global $soapClientController;
            return $soapClientController->actualizarDatosUsuario($parametros);
        }

    }
    catch(Exception $ex){
        echo "Exception ocurred: " . $ex;
    }

?>