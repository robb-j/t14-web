<?php
	class HeatMapGroup extends Object {
	
		//	Longitude
		private $lng;
		
		//	Latitude
		private $lat;
		
		//	Amount spent within the group
		private $amount;
		
		//	The radius defined as "close"
		private $radius
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $lng, $lat, $radius){
		
			$this->setLng($lng);
			$this->setLat($lat);
			$this->setRad($radius);
		}
		
		// Getters
		public function getLng(){
			
			return $this->lng;
		}

		public function getLat(){
			
			return $this->lat;
		}
		
		public function getAmount(){
			
			return $this->amount;
		}
		
		public function getRadius(){
			
			return $this->radius;
		}
		
		public function close($newLng, $newLat){
		
			if(abs($this->lng - $newLng) <= 0.0002 && abs($this->lat - $newLat) <= 0.0002){
				return true;
			}else{
				return false;
			}
		}
		
		public function addAmount($amount){
		
			$this->amount + $amount;
		}
		
		
		//These are private as once they are set we don't want them to be able to change
		private function setlng($lng){
			
			$this->lng = $lng;
		}
		
		private function setlat($lat){
			
			$this->lat = $lat;
		}
		
		private function setRad($rad){
			
			$this->radius = $rad;
		}
	}
?>