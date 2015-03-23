<?php
	class RewardTakenOutput extends Object {
		
		// The account that transactions were loaded for
		private $rewardTaken;
		
		// The transactions that were loaded 
		private $reward;
		
		private $didPass;
		
		//This constructor takes in these parameters and sets the relevant fields
		public function __construct( $reward, $rewardTaken, $didPass = false ){
		
			$this->setRewardTaken($rewardTaken);
			$this->setReward($reward);
			$this->setDidPass($didPass);
			
		}
		
		public function getRewardTaken(){
			
			return $this->rewardTaken;
			
		}
		
		public function getReward(){
			
			return $this->reward;
			
		}
		
		public function didPass(){
			
			return $this->didPass;
			
		}
		
		//These are private as once they are set we don't want them to be able to change
		private function setRewardTaken($rewardTaken){
			
			$this->rewardTaken = $rewardTaken;
		
		}
		
		private function setReward($reward){
			
			$this->reward = $reward;
		}
		
		private function setDidPass($didPass){
			
			$this->didPass = $didPass;
		}
	}
?>
