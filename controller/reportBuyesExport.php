<?php

	//$data = json_decode(file_get_contents('php://input'),true);

	$dateStart = date_format(date_create($_GET['dateStart']), "Y-m-d");
	$dateFinish = date_format(date_create($_GET['dateFinish']), "Y-m-d");

	require_once('config/dbConnectionStore.php');

	$result = mysql_query("CALL getRowsForGenerateReport('".$dateStart."','".$dateFinish."');", $connection) or die(mysql_error());
	$countRows = mysql_num_rows($result);

	if ($countRows > 0) {

		date_default_timezone_set('America/Bogota');

		$filenameToGenerate = "REPORTE_COMPRAS_" . date("dmYHis") . ".xlsx";

		/** Se agrega la libreria PHPExcel */
		require_once 'module/PHPExcel/PHPExcel.php';

		// Se crea el objecto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("SoleStore") // Nombre del autor
    	->setLastModifiedBy("SoleStore") //Ultimo usuario que lo modificó
    	->setTitle("Reporte de Compras SoleStore") // Titulo
    	->setSubject("Reporte de Compras SoleStore") //Asunto
    	->setDescription("Reporte de compras SoleStore") //Descripción
    	->setKeywords("reporte compras solestore") //Etiquetas
    	->setCategory("Reporte excel"); //Categorias

    	$titleReport = "Relación de compras realizadas";
    	$titleColumns = array('ID COMPRA', 'CLIENTE', 'FECHA', 'PRODUCTO', 'PRECIO UNITARIO', 'CANTIDAD COMPRADA', 'SUBTOTAL');

    	// Se combinan las celdas A1 hasta G1, para colocar ahí el titulo del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    		->mergeCells('A1:G1');

    	// Se agregan los titulos del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    		->setCellValue('A1', $titleReport) // Titulo de reporte
    		->setCellValue('A3', $titleColumns[0])
    		->setCellValue('B3', $titleColumns[1])
    		->setCellValue('C3', $titleColumns[2])
    		->setCellValue('D3', $titleColumns[3])
    		->setCellValue('E3', $titleColumns[4])
    		->setCellValue('F3', $titleColumns[5])
    		->setCellValue('G3', $titleColumns[6]);

    	// Se agregan los datos de los alumnos
    	$i = 4; // Número de fila donde se va a comenzar a rellenar

    	while ($row = mysql_fetch_array($result)) {
    		$objPHPExcel->setActiveSheetIndex(0)
    			->setCellValue('A'.$i, $row['purchase_id'])
    			->setCellValue('B'.$i, $row['fullname'])
    			->setCellValue('C'.$i, $row['date_create'])
    			->setCellValue('D'.$i, $row['product'])
    			->setCellValue('E'.$i, $row['price_unitary'])
    			->setCellValue('F'.$i, $row['count'])
    			->setCellValue('G'.$i, $row['subtotal']);
    		$i++;
    	}

    	///////

    	$styleTitleReport = array(
		    'font' => array(
		        'name'      => 'Verdana',
		        'bold'      => true,
		        'italic'    => false,
		        'strike'    => false,
		        'size' =>16,
		        'color'     => array(
		            'rgb' => 'FFFFFF'
		        )
		    ),
		    'fill' => array(
		      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
		      'color' => array(
		            'argb' => 'FF220835')
		  ),
		    'borders' => array(
		        'allborders' => array(
		            'style' => PHPExcel_Style_Border::BORDER_NONE
		        )
		    ),
		    'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        'rotation' => 0,
		        'wrap' => TRUE
		    )
		);
		 
		$styleTitleColumns = array(
		    'font' => array(
		        'name'  => 'Arial',
		        'bold'  => true,
		        'color' => array(
		            'rgb' => 'FFFFFF'
		        )
		    ),
		    'fill' => array(
		        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		  'rotation'   => 90,
		        'startcolor' => array(
		            'rgb' => '2658FC'
		        ),
		        'endcolor' => array(
		            'argb' => '4C75FC'
		        )
		    ),
		    'borders' => array(
		        'top' => array(
		            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
		            'color' => array(
		                'rgb' => '143860'
		            )
		        ),
		        'bottom' => array(
		            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
		            'color' => array(
		                'rgb' => '143860'
		            )
		        )
		    ),
		    'alignment' =>  array(
		        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        'wrap'      => TRUE
		    )
		);
		 
		$styleInformation = new PHPExcel_Style();
		$styleInformation->applyFromArray( array(
		    'font' => array(
		        'name'  => 'Arial',
		        'color' => array(
		            'rgb' => '000000'
		        )
		    ),
		    'fill' => array(
		  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
		  'color' => array(
		            'argb' => 'C8D3FA')
		  ),
		    'borders' => array(
		        'left' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN ,
		      'color' => array(
		              'rgb' => '3a2a47'
		            )
		        )
		    )
		));

		// Aplicamos el estilo al titulo, a las columnas y al contenido a mostrar.

		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleTitleReport);
		$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleTitleColumns);
		$objPHPExcel->getActiveSheet()->setSharedStyle($styleInformation, "A4:G".($i-1));

		// Ajustamos las columnas según el contenido de cada celda
		for($i = 'A'; $i <= 'G'; $i++){
		    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
		}

		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Reporte Compras');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre.
		$objPHPExcel->setActiveSheetIndex(0);

		// Inmovilizar paneles
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0, 4);



		// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$filenameToGenerate);
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	} else {
		echo "Ningun resultado devuelto";
	}