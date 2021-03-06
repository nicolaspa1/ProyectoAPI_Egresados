<?php

require "../PHPOffice/PHPExcel/Classes/PHPExcel/IOFactory.php";
require_once "conexion.php";
require_once "funciones.php";
if (isset($_POST["enviar"])) {

    $archivo = $_FILES["archivo"]["name"];
    $archivo_copiado = $_FILES["archivo"]["tmp_name"];
    $archivo_guardado = "archivos/copia_" . $archivo;

    $info = new SplFileInfo($archivo_guardado); //Informacion del archivo OBJECT

    $extension = $info->getExtension();

    if (file_exists($archivo_guardado) && ($extension == 'xlsx' || $extension == 'xls')) {
        # code...

        $objPHPExcel = PHPExcel_IOFactory::load($archivo_guardado);
        $objPHPExcel->setActiveSheetIndex(0);

        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $char = 'A';
        for ($i = 2; $i <= $numRows; $i++) {

            $codigo = $objPHPExcel->getActiveSheet()->getCell('A' . $i);
            $nombres = $objPHPExcel->getActiveSheet()->getCell('B' . $i);
            $apellidos = $objPHPExcel->getActiveSheet()->getCell('C' . $i);
            $fecha_ingreso = $objPHPExcel->getActiveSheet()->getCell('D' . $i);
            $fecha_egreso = $objPHPExcel->getActiveSheet()->getCell('E' . $i);
            $cedula = $objPHPExcel->getActiveSheet()->getCell('F' . $i);

            echo "<br/>" . $codigo . "--" . $nombres . "--" . $apellidos . "--" . $fecha_ingreso . "--" . $fecha_egreso . "--" . $cedula . "--";

            insertar($codigo, $nombres, $apellidos, $fecha_ingreso, $fecha_egreso, $cedula, $conexion);
        }
        // echo $char++;    --> Esto para si no se sabe desde que parte del excel se encuentra especificar cordenadas 
        //Se puede hacer mediante recepcion de datos de esos X y Y
    } else {
        echo error_archivo_incorrecto();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivo</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="formulario">
        <form action="excel.php" class="formularioCompleto" method="POST" enctype="multipart/form-data">
            <input class="btn btn-info" type="file" name="archivo" class="form_control" />
            <input class="btn btn-success"type="submit" value="SUBIR ARCHIVO" name="enviar" />
        </form>
    </div>

</body>

</html>