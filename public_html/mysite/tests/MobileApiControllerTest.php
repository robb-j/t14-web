<?php

class MobileApiControllerTest extends FunctionalTest {
	
	
	static $fixture_file = 'mysite/tests/MobileUsers.yml';
	
	private $token;
	private $userID;
	
	
	/**
	 * @Before
	 */
	public function setup() {
		
		// Something that happens before EACH test
		parent::setup();
		
		
		$output = BankAccessor::create()->login("robster31", "password", null, false);
		
		$this->token = $output->getToken();
		$this->userID = $output->getUser()->ID;
	}
	
	/**
	 * @TearDown
	 */
	public function tearDown() {
		
		// Something that happens after EACH test
		parent::tearDown();
		
		
		BankAccessor::create()->logout($this->userID, $this->token);
	}

	public function testUpdateBudgetPassing() {
		
		// Create the url & post data
		$url = "bankapi/updateBudget";
		$postData = array(
			"token" => $this->token,
			"userID" => $this->userID,
			"groups" => array(
				array(
					"id" => "1",
					"mode" => "delete"
				),
				array(
					"id" => "2",
					"mode" => "edit",
					"title" => "Spending Money",
					"categories" => array(
						array(
							"id" => "2",
							"mode" => "delete"
						),
						array(
							"id" => "3",
							"mode" => "edit",
							"title" => "Health",
							"budget" => "120.00"
						),
						array(
							"mode" => "create",
							"title" => "Going Out",
							"budget" => "80.00"
						)
					)
				),
				
				array(
					"mode" => "create",
					"title" => "Saving",
					"categories" => array(
						array(
							"mode" => "create",
							"title" => "Car Fund",
							"budget" => "500.00"
						)
					)
				)
				
			),
			
		);
		
		
		// Perform the update
		$page = $this->post($url, $postData);
		
		
		
		
		/* 
			Test the database entries
		*/
		$allGroups = BudgetGroup::get();
		$allCats = Category::get();
		
		// Get each group
		$g1 = $allGroups->byId(1);
		$g2 = $allGroups->byId(2);
		$g3 = $allGroups->byId(3);
		
		
		
		// Test it delted the first group
		$this->assertNull($g1);
		
		
		
		
		// Test it left the second alone
		$this->assertNotNull($g2);
		
		// Test it updated the 2nd group's name
		$this->assertEquals("Spending Money", $g2->Title);
		
		// Test it deleted the first category
		$g2c1 = $g2->Categories()->byId(2);
		$this->assertNull($g2c1);
		
		// Test it edited the second category
		$g2c2 = $g2->Categories()->byId(3);
		$this->assertEquals("Health", $g2c2->Title);
		$this->assertEquals(120.00, $g2c2->Budgeted);
		$this->assertEquals(0.00, $g2c2->Balance);
		
		// Test it added a category
		$g2c3 = $g2->Categories()->byId(4);
		$this->assertNotNull($g2c3);
		$this->assertEquals("Going Out", $g2c3->Title);
		$this->assertEquals(80.00, $g2c3->Budgeted);
		$this->assertEquals(0.00, $g2c3->Balance);
		
		
		
		
		// Test it created the third Group & added a category to it
		$this->assertNotNull($g3);
		
		// Test the group was assigned to the user
		$this->assertEquals(1, $g3->UserID);
		
		// Test it has a category
		$this->assertEquals(1, $g3->Categories()->count());
		
		// Test it's category was created correctly
		$g3c1 = $g3->Categories()->byId(5);
		$this->assertNotNull($g3c1);
		$this->assertEquals("Car Fund", $g3c1->Title);
		$this->assertEquals(500.00, $g3c1->Budgeted);
		$this->assertEquals(0.00, $g3c1->Balance);
		
		
		
		
		/*
			Test the Output
		*/
		$output = Convert::json2array($page->getBody());
		$this->assertNotNull($output);
		
		
		// Check it has groups
		$this->assertTrue(array_key_exists("Groups", $output));
		
		
		// Check it has categories
		$this->assertTrue(array_key_exists("Categories", $output));
		
		
		
		
	}
	
}

?>