<?php

/* 
 * Created by Martin Smith - Mar 2015
 */
	class HeatMapGroup extends ArrayData {
	
		//	Longitude
		private $lng = 0.0;
		
		//	Latitude
		private $lat = 0.0;
		
		//	Amount spent within the group
		private $amount = 0.0;
		
		//	The radius defined as "close"
		private $radius;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $lng, $lat, $radius){
		
			parent::__construct(array(
				"Latitude" => $lat,
				"Longitude" => $lng,
				"Radius" => $radius,
				"Amount" => 0.0
			));
		}
		
		// Getters
		public function getLng(){
			
			return $this->getField("Longitude");
		}

		public function getLat(){
			
			return $this->getField("Latitude");
		}
		
		public function getAmount(){
			
			return $this->getField("Amount");
		}
		
		public function getRadius(){
			
			return $this->getField("Radius");
		}
		
		public function close($newLng, $newLat){
			
			$latitude = $this->getLat();
			$longitude = $this->getLng();
			
			if(abs($longitude - (double)$newLng) <= 0.0002 && abs($latitude - (double)$newLat) <= 0.0002){
				return true;
			}else{
				return false;
			}
		}
		
		public function addAmount($amount){
			
			$totalAmount = $this->getField("Amount") + abs($amount);
			$this->setField("Amount", $totalAmount);
		}
		
		
	}
?>