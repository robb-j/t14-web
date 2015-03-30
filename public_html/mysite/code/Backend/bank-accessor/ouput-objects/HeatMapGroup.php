<?php
	class HeatMapGroup extends Object {
	
		private $lng;
		private $lat;
		private $amount;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $lng, $lat){
		
			$this->setLng($lng);
			$this->setLat($lat);

		}
		
		
		
		// Getters
		public function getLng(){
			
			return $this->lng;
			
		}
		
		// Getters
		public function getLat(){
			
			return $this->lat;
			
		}
		
		// Getters
		public function getAmount(){
			
			return $this->Amount;
			
		}
		
		public function close($newLng, $newLat){
		
			if(abs($this->lng - $newLng) <= 0.0002 && abs($this->lat - $newLat) <= 0.0002){
				return true;
			}else{
				return false;
			}
		}
		
		public function addAmount($amount){
		
			$this->Amount + $amount;
		}
		
		
		//These are private as once they are set we don't want them to be able to change
		private function setlng($lng){
			
			$this->lng = $lng;
		
		}
		
		//These are private as once they are set we don't want them to be able to change
		private function setlat($lat){
			
			$this->lat = $lat;
		
		}
		
		
	}
?>
