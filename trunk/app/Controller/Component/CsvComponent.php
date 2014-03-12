<?php
App::uses('Component', 'Controller');

class CsvComponent extends Component {

  protected $_fp;
  public $default = array(
    'filename' => 'export.csv',
		'delimiter' => ',',
		'enclosure' => '"',
    'max_execution_time' => 180
	);
  
  public function initialize(Controller $controller) {
    $this->controller = $controller;
    $this->settings = array_merge($this->default,$this->settings);
    $this->_fp = fopen('php://temp/maxmemory:'. (2*1024*1024), 'r+');
  }
  
  public function addRow($row){
    fputcsv($this->_fp, $row, $this->settings['delimiter'], $this->settings['enclosure']); 
  }
  
  public function renderHeaders() { 
  	ob_end_clean();
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename=audit_reports.csv');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM
  } 
     
  public function export($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") { 
    // setting timeout for large data exports.
    if( !ini_get('safe_mode') && ini_get('max_execution_time') < $this->settings['max_execution_time']  ){ 
       set_time_limit($this->settings['max_execution_time']);
    }
    if ($outputHeaders) { 
      $this->renderHeaders(); 
    } 
    
    rewind($this->_fp); 
    $output = '';
    while ( feof($this->_fp) === false ) {
        $output .= fgets($this->_fp);
    }
    fclose($this->_fp);
    if ($to_encoding) {     	
//         $output = chr(239) . chr(187) . chr(191) .$output;//mb_convert_encoding($output , 'UTF-8' , 'UTF-16LE');//chr(255).chr(254).mb_convert_encoding($output, $to_encoding, $from_encoding);
    	echo pack("CCC", 0xef, 0xbb, 0xbf).$output; 
    } 
    return $output; 
  } 
    
}