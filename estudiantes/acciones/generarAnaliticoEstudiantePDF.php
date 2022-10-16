<?php

/*
** reportes/acciones/generarAnaliticoEstudiantePDF.php
**
** GENERAR PDF DE ANALITICO DE ESTUDIANTE
**
*/
    # VARIABLES
    
    //$convocatorias = array();

    //$identificadoresConvocatorias = $_POST["convocatorias"];

    //$identificadoresConvocatorias = unserialize($identificadoresConvocatorias);

    // TCPDF LIBRARY
    require_once('tcpdf/tcpdf.php');

    #   PERSONALIZACION DEL HEADER
    class TCPDFSga extends TCPDF {

        public function Header() {

            # LOGO
            $image_file = K_PATH_IMAGES.'logoUNLa.png';
            $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            # FUENTE
            $this->SetFont('helvetica', 'B', 20);
            # TITULO
            //$this->Cell($w, $h=0, $txt='', $border=0, $ln=2, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
            // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
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
            <h1>Sistema de gestión académica<br>Universidad Nacional de Lanús</h1>
            </body>'
            , $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);

        }

        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-20);
            // Set font
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
    $pdf->SetTitle('Analitico de estudiante');
    $pdf->SetSubject('Analitico de estudiante');
    $pdf->SetKeywords('UNLa, analitico, estudiante, sga');

    // MARGENES
    $pdf->SetMargins(7, 32, 7);
    // SET AUTO PAGE BREAKS
    $pdf->SetAutoPageBreak(TRUE, 38);

    $pdf->AddPage();
    $pdf->setPage($pdf->getPage());

    // VARIABLES

    $carrera = $estudiante->{'carrera'};
    $estudiante = $estudiante->{'estudiante'};
    $promedio = 0;

    $html = "
        <style>

            th {
                height: 25px;
            }

            th.firstColumn {
                width: 40%;
            }

            th.secondColumn {
                width: 30%;
            }
            
            th.thirdColumn {
                width: 15%;
            }

            th.fourthColumn {
                width: 15%;
            }

            td {
                height: 25px;
            }

        </style>
        <body>
            <b>Analítico de estudiante</b>
            <br><br><br>
            <b>Carrera</b>: $carrera
            <br>
            <b>Estudiante</b>: $estudiante
            <br><br><br>
            <table>
                <tr>
                    <th class=\"firstColumn\">
                        <b>Materia</b>
                    </th>
                    <th class=\"secondColumn\">
                        <b>Docente</b>
                    </th>
                    <th class=\"thirdColumn\">
                        <b>Fecha</b>
                    </th>
                    <th class=\"fourthColumn\">
                        <b>Nota</b>
                    </th>
                </tr>";
        
        foreach ($historialAcademicoList as $historialAcademico) {

            $materia = $historialAcademico->{'materia'};
            $fecha = date("d/m/Y", strtotime($historialAcademico->{'fecha'}));      
            $nota = $historialAcademico->{'nota'};
            $docente = $historialAcademico->{'docente'};
            $promedio = $promedio + intval($nota);

            $html .= "
                    <tr>
                        <td>
                            $materia
                        </td>
                        <td>
                            $docente
                         </td>
                        <td>
                            $fecha
                        </td>
                        <td>
                            $nota
                        </td>
                    </tr>";

        }

        $promedio = $promedio/count($historialAcademicoList);

        $html .= "
            </table>
            <br><br><br>
            <b>Promedio general:</b> $promedio
        </body>";

    # AGREGO EL CONTENIDO AL PDF
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    # CIERRA Y GENERA EL PDF
    # I: send the file inline to the browser. The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
    # D: send to the browser and force a file download with the name given by name.
    # F: save to a local file with the name given by name (may include a path).
    # S: return the document as a string. name is ignored. 
    //$pdf->Output('convocatotorias.pdf', 'D');

    //$pdf->Output(__DIR__.'..\..\archivos\analiticoEstudiante.pdf', 'F');

    $pdf->Output(__DIR__.'..\..\archivos\analiticoEstudiante.pdf', 'I');

    // $url = "../archivos/analitico.pdf";
    //header("Location: $url");

?>