<?php

/* A Tool Page that displays the Heatmap
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