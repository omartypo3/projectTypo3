<?php
namespace Emagineurs\EImportExport\Handlers\Export;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Ian SEBBAGH <isebbagh@e-magineurs.com>, E-magineurs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * The repository for Confs
 */
class CsvHandlers extends AbstractHandlers {
	/**
	 * Write header for file type
	 * 
	 * @access protected
	 * @return void
	 */
	public function header(){
		header('Content-Type:application/csv;charset=utf-8');
		header('Content-Disposition: attachment; filename=data.csv');
	}		
	
	/**
	 * Build the file content
	 * 
	 * @param resource|null $outputHandle
	 * @access protected
	 * @return void
	 */
	protected function write($outputHandle = null){
		$dataFinal = $this->datas;
		$input_array = [];
		$iterator = 0;
		foreach($dataFinal as  $data){
			if($iterator == 0){
				foreach($data as $key =>$entete){
					$input_array[0][] = $key;
				}
				
			}
			$input_array[] = $data;
			
			$iterator ++;
		}
		
		$this->convert_to_csv($input_array, $outputHandle, ";");
	}

	/**
	 * Convert array to CSV
	 * 
	 * @param array $input_array
	 * @param resource $outputHandle
	 * @param string $delimiter
	 * @access protected
	 * @return void
	 */
	private function convert_to_csv($input_array, $outputHandle, $delimiter){
		foreach ($input_array as $line) {
			fputcsv($outputHandle, $line, $delimiter);
		}
	}
}
