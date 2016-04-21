<?php
require_once 'excel/Classes/PHPExcel.php';
$objReader = PHPExcel_IOFactory::createReaderForFile("booktest.xlsx");
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load("booktest.xlsx");
$objWorksheet = $objPHPExcel->getActiveSheet();
$highestRow = $objWorksheet->getHighestRow(); 
echo "highest row = ".$highestRow." ".nl2br("\n");

$highestColumn = $objWorksheet->getHighestColumn();

$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
echo "highestColumnIndex = ".$highestColumnIndex.nl2br("\n"); 

echo "highest column = ".$highestColumn.nl2br("\n");

for ($Row = 1; $Row <= $highestRow; ++$Row) {
	for ($col = 0; $col < $highestColumnIndex; ++$col) {
		$value = $objWorksheet->getCellByColumnAndRow($col,$Row)->getValue();
		echo "The value of cell ".$Row.",".$col." = ".$value.nl2br("\n");
	}
}

/*$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
//$objWriter->save("ak.htm");
echo $objWriter->generateHTMLHeader();
echo $objWriter->generateSheetData();
echo $objWriter->generateHTMLFooter();
*/?>