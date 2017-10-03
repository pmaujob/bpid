<?php
@session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 8; //id 8 pertenece a certificados viabilidad
const idEtapa = 2; //id 2 pertenece a los archivos ya radicados
$sess = new SessionVars();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_certificados_viabilidad.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <?php require_once '../menu.php'; ?>            
            <form id='frm_meta_producto' name='frm_meta_producto' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="row">
                            <div class="col s12 m12 l12 center-align">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="titulofrm">CERTFICADOS DE VIABILIDAD</div>
                            </div>                            
                        </div>

                        <div class="row">
                            <div class="col m12 l2">

                            </div>

                            <div class="col s12 m8 l8">
                                <div class="row">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th width="400px">Certificado</th>
                                                <th width="100px">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Informe de Viabilidad</td>
                                                <td>
                                                    <a href="../certificados/informeViabilidad.php" title="Ver Más">
                                                        <div onclick="mas(1);">
                                                            <img style="width: 50%; height: 50%;" src="../../vistas/img/pdf.png">
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Certificado de Viabilidad</td>
                                                <td>
                                                    <a href="#" title="Ver Más">
                                                        <div onclick="mas(2);">
                                                            <img style="width: 50%; height: 50%;" src="../../vistas/img/pdf.png">
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Certificado de NO Viabilidad</td>
                                                <td>
                                                    <a href="#" title="Ver Más">
                                                        <div onclick="mas(3);">
                                                            <img style="width: 50%; height: 50%;" src="../../vistas/img/pdf.png">
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Solicitud de Registro</td>
                                                <td>
                                                    <a href="#" title="Ver Más">
                                                        <div onclick="mas(4);">
                                                            <img style="width: 50%; height: 50%;" src="../../vistas/img/pdf.png">
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col m12 l2">

                            </div>

                        </div>

                    </div>      
                </div>
            </form>
        </body>

    </html>
    <?php
}
?>
