<?php

    # REPORTES CONTROLLER

    //$wsdl_url = 'http://localhost:8080/JAXWS-SSDD/reportes?wsdl';
    $wsdl_url = 'https://gestion-academica-soap.herokuapp.com/reportes?wsdl';

    try{

        $soapClientController = new SOAPClient($wsdl_url);

        function traerMateriasAprobadasPorEstudiante($parametros){
            global $soapClientController;
            return $soapClientController->traerMateriasAprobadasPorEstudiante($parametros);
        }

        function traerEstudiantesInscriptosPorMateria($parametros){
            global $soapClientController;
            return $soapClientController->traerEstudiantesInscriptosPorMateria($parametros);
        }

        function traerMateriasPorInscripcionYCarreraYTurno($parametros){
            global $soapClientController;
            return $soapClientController->traerMateriasPorInscripcionYCarreraYTurno($parametros);
        }

        function traerComisionesPorInstanciaYMateria($parametros){
            global $soapClientController;
            return $soapClientController->traerComisionesPorInstanciaYMateria($parametros);
        }

    }
    catch(Exception $ex){
        echo "Exception ocurred: " . $ex;
    }

?>