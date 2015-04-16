<?php

/* A controller that sends out the monthly email updates
 * Created by Martin S - April 2015
 */
class EmailController extends Controller {

   private static $allowed_actions = array(
      "MonthlyDigest"
   );
   
   public function MonthlyDigest() {
		BankAccessor::create()->monthlyAccountUpdate();
		return "<p> Account updates sent out </p>";
   }
}
?>