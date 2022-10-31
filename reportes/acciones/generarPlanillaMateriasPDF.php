<?php

/*
** reportes/acciones/generarPlanillaMaterias.php
**
** GENERAR PDF DE PLANILLA DE MATERIAS
**
*/

    # TCPDF LIBRARY
    require_once('tcpdf/tcpdf.php');

    class TCPDFSga extends TCPDF {

        public function Header() {

            $image_file = K_PATH_IMAGES.'logoUNLa.png';
            $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetFont('helvetica', 'B', 20);
            $this->writeHTMLCell(0, 150, 0, 0, $html='
            <style>
                h1{
                    font-size: 12px;
                    color: #000;
                    text-align: center;
                    padding-bottom: 15px;
                }
            </style>
            <body>
            <h1>Sistema de Gestión Académica<br>Universidad Nacional de Lanús</h1>
            </body>'
            , $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);

        }

        public function Footer() {
            $this->SetY(-20);
            $this->SetFont('helvetica', 'I', 8);

            $html='
            <style>
                a{
                    color: #7c1331;
                    text-decoration: none;
                }
                h4{
                    font-size: 10px;
                    color: #000;
                    text-align: center;
                    padding-bottom: 15px;
                }
            </style>
            <body>
                <h4>Más información: <a href="http://www.unla.edu.ar/">Universidad Nacional de Lanús</a><br><br>
            </body>';

            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
            $this->Cell(0, 18, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }

    }

    # CREAR DOCUMENTO PDF
    $pdf = new TCPDFSga(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    # INFORMACION DEL DOCUMENTO
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('UNLa');
    $pdf->SetTitle('Planilla de materias');
    $pdf->SetSubject('Planilla de materias');
    $pdf->SetKeywords('UNLa, planilla, materias, sga');
    $pdf->SetMargins(7, 32, 7);
    $pdf->SetAutoPageBreak(TRUE, 38);
    $pdf->AddPage('L');
    $pdf->setPage($pdf->getPage());

    # VARIABLES
    $error = $materiasInscripcion->{'error'};
    $estado = $materiasInscripcion->{'estado'};
    $carrera = $materiasInscripcion->{'carrera'};
    $descripcion = $materiasInscripcion->{'descripcion'};
    $instancia = $materiasInscripcion->{'instancia'};
    $turno = $materiasInscripcion->{'turno'};
    $idInstancia = $materiasInscripcion->{'idInstancia'};
    $anioActual = 0;

    if($estado == "SUCCESS"){

        if(isset($materiasInscripcion->{'materiasInscripcion'})){

            $materiasInscripcionList = $materiasInscripcion->{'materiasInscripcion'};

            # ORDEN POR ANIO CARRERA
            usort($materiasInscripcionList, fn($a, $b) => $a->{'anioCarrera'} <=> $b->{'anioCarrera'});

            $html = "
                <style>

                    table {
                        font-size: 12px;
                    }

                    th {
                        height: 25px;
                    }

                    th.firstColumn {
                        width: 15%;
                    }

                    th.secondColumn {
                        width: 40%;
                    }
                    
                    th.thirdColumn {
                        width: 25%;
                    }

                    th.fourthColumn {
                        width: 30%;
                    }

                    td {
                        height: 25px;
                        border-top: 0.5px dashed #888888;
                    }

                </style>
                <body>
                    <b>Planilla de materias</b><br>
                    $descripcion
                    <br><br>
                    <b>Carrera</b>: $carrera
                    <br>
                    <b>Instancia</b>: $instancia
                    <br>
                    <b>Turno</b>: $turno
                    <br><br><br>
                    <table>";

                // FORMATO DE LA TABLA SEGUN INSTANCIA

                if($idInstancia == 1){

                    $caberceraTabla = "<tr>
                    <th class=\"firstColumn\">
                        <b>Comisión</b>
                    </th>
                    <th class=\"secondColumn\">
                        <b>Materia</b>
                    </th>
                    <th class=\"thirdColumn\">
                        <b>Docente</b>
                    </th>
                    <th class=\"fourthColumn\">
                        <b>Horario</b>
                    </th>
                </tr>";

                    foreach ($materiasInscripcionList as $materiaInscripcion) {

                        if($materiaInscripcion->{'anioCarrera'} != $anioActual){
                            $anioActual = $materiaInscripcion->{'anioCarrera'};
                            if($anioActual == 1){
                                $html .= "<br><b>Primer año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 2){
                                $html .= "<br><b>Segundo año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 3){
                                $html .= "<br><b>Tercer año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 4){
                                $html .= "<br><b>Cuarto año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 5){
                                $html .= "<br><b>Quinto año</b><br><br>$caberceraTabla";
                            }
                        }

                        $comision = $materiaInscripcion->{'comision'};
                        $nombreMateria = $materiaInscripcion->{'materia'};
                        $docente = $materiaInscripcion->{'docente'};
                        $horarioCursada = $materiaInscripcion->{'horarioCursada'};

                        $html .= "
                                <tr>
                                    <td>
                                        $comision
                                    </td>
                                    <td>
                                        $nombreMateria
                                    </td>
                                    <td>
                                        $docente
                                    </td>
                                    <td>
                                        $horarioCursada
                                    </td>
                                </tr>";

                    }

                    $html .= "
                        </table>
                    </body>";
                }
                elseif($idInstancia == 2){

                    $caberceraTabla = "<tr>
                    <th class=\"firstColumn\">
                        <b>Comisión</b>
                    </th>
                    <th class=\"secondColumn\">
                        <b>Materia</b>
                    </th>
                    <th class=\"thirdColumn\">
                        <b>Docente</b>
                    </th>
                    <th class=\"fourthColumn\">
                        <b>Fecha</b>
                    </th>
                </tr>";

                    foreach ($materiasInscripcionList as $materiaInscripcion) {

                        if($materiaInscripcion->{'anioCarrera'} != $anioActual){
                            $anioActual = $materiaInscripcion->{'anioCarrera'};
                            if($anioActual == 1){
                                $html .= "<br><b>Primer año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 2){
                                $html .= "<br><b>Segundo año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 3){
                                $html .= "<br><b>Tercer año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 4){
                                $html .= "<br><b>Cuarto año</b><br><br>$caberceraTabla";
                            }
                            elseif($anioActual == 5){
                                $html .= "<br><b>Quinto año</b><br><br>$caberceraTabla";
                            }
                        }

                        $comision = $materiaInscripcion->{'comision'};
                        $nombreMateria = $materiaInscripcion->{'materia'};
                        $docente = $materiaInscripcion->{'docente'};
                        $fechaMesaString = strval($materiaInscripcion->{'fechaMesa'});
                        $fechaMesa = date("d/m/Y", strtotime(explode(' ',$fechaMesaString)[0])) . " " . explode(' ',$fechaMesaString)[1];
                        
                        $html .= "
                                <tr>
                                    <td>
                                        $comision
                                    </td>
                                    <td>
                                        $nombreMateria
                                    </td>
                                    <td>
                                        $docente
                                    </td>
                                    <td>
                                        $fechaMesa
                                    </td>
                                </tr>";

                    }

                    $html .= "
                        </table>
                    </body>";

                }
            
        }
    }
    else{
        $html = $error;
    }

    # AGREGO EL CONTENIDO AL PDF
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    # CIERRA Y GENERA EL PDF
    # I: send the file inline to the browser. The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
    # D: send to the browser and force a file download with the name given by name.
    # F: save to a local file with the name given by name (may include a path).
    # S: return the document as a string. name is ignored. 

    $pdf->Output('planillaMaterias.pdf', 'I');

?>