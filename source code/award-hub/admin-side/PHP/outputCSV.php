<?php
/************************ Function: outputCSV() ********************************
* Description:  Function to convert response from DB query into CSV format and
                initiate download of new file to client's local machine.
* Parameters:   mysqli_result object,
                name for download file,
                debugging boolean(optional)
* Output:       CSV file download
* Sources:      https://stackoverflow.com/questions/217424/create-a-csv-file-for-a-user-in-php
*******************************************************************************/
function outputCSV($data, $fileName, $debug=false) {
  //Set necessary headers
  header("Content-Type: text/csv");
  header("Content-Disposition: attachment; filename=${fileName}");

  $output = fopen("php://output", "w");

  //Write columns names to file
  $fieldNames = [];
  while ($field = mysqli_fetch_field($data)) {
    $fieldNames[] = $field->name;
  }
  fputcsv($output, $fieldNames);

  if($debug)
    error_log(print_r($fieldNames,true)); //Prints field names to server log

  //Write column data to file
  foreach ($data as $row)
    fputcsv($output, $row); // here you can change delimiter/enclosure
  fclose($output);
}
