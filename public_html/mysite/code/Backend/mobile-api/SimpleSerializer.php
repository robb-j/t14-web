<?php

/* An Object that HEAVILY uses colymba/restfulapi 's RESTfulAPI_BasicSerializer
 * Subclassed that to add the ability to jsonify key-arrays with DataObjects & lists in them
 * Created by Rob A - Mar 2015
 */
class SimpleSerializer extends RESTfulAPI_BasicSerializer {
	
	
	// Turns a keyed array of DataObjects into a formetted one (ready to be jsonified)
	protected function formatArray($input) {
		
		$output = array();
		
		foreach ($input as $key => $value) {
			
			if ($value instanceof DataObject) {
				
				$output[$key] = $this->formatDataObject($value);
			}
			else if ($value instanceof DataList) {
				
				$output[$key] = $this->formatDataList($value);
			}
			else if ($value instanceof ArrayList) {
				
				$output[$key] = $this->formatArray($value);
			}
			else if (is_string($value) || is_numeric($value) ) {
				
				$output[$key] = $value;
			}
		}
		
		return $output;
	}
	
	
	// Turns a formatted keyed-array into a json string
	public function serializeArray($input) {
		
		$output = $this->formatArray( $input );
		return $this->jsonify( $output );
	}
}