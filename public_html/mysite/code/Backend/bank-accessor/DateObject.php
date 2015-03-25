<?php
	class DateObject extends Object {
		
		private $day;
		private $month;
		private $year;

		
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $day, $month, $year){
		
			$this->setDay($day);
			$this->setMonth($month);
			$this->setYear($year);
		}
	
		public function getDay() {
			return $this->day;
		}
		
		public function getMonth() {
			return $this->month;
		}
		
		public function getYear(){
			return $this->year;
		}
		
		public function getFormat() {
			return $this->day." ".$this->month." ".$this->year;
		}
		
		public function getLongFormat(){
		
			return date('d F Y', strtotime("$this->day-$this->month-$this->year"));
		
		}

		
		//These are private as once they are set we don't want them to be able to change
		private function setDay($day){
			
			$this->day = $day;
		
		}
		
		private function setMonth($month){
			
			$this->month = $month;
		
		}
		
		private function setYear($year){
			
			$this->year = $year;
		
		}

	}
?>
