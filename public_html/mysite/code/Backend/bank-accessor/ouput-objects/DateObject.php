<?php

/* 
 * Created by Martin Smith - Mar 2015
 */
 
	class DateObject extends ArrayData {

		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $day, $month, $year){
			
			parent::__construct(array(
				"Day" => $day,
				"Month" => $month,
				"Year" => $year
			));
		}
	
		public function getDay() {
			return $this->getField("Day");
		}
		
		public function getMonth() {
			return $this->getField("Month");
		}
		
		public function getYear(){
			return $this->getField("Year");
		}
		
		public function Nice() {
			
			return $this->getDay()." ".$this->MonthAndYear();
		}
		
		public function MonthAndYear() {
			
			$month = date("M", mktime(0, 0, 0, intval($this->getMonth()), 10));
			return $month." ".$this->getYear();
		}
		
		public function getLongFormat(){
		
			return date('d F Y', strtotime($this->getDay()."-".$this->getMonth()."-".$this->getYear()));
		}

		
		//These are private as once they are set we don't want them to be able to change
		private function setDay($day){
			
			$this->setField("Day", $day);
		}
		
		private function setMonth($month){
			
			$this->setField("Month", $month);
		}
		
		private function setYear($year){
			
			$this->setField("Year", $year);
		}
	}
?>