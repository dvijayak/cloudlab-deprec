<?PHP  
 	 header("Content-Type: text/html; charset=UTF-8");  
	// Your PHP Function   
	class Validation {  
		private $EmailTester;  
	  
		public function __construct(){  
			$this->EmailTester = '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';  
		}  
		public function validateEmail($email){  
			$test = preg_match($this->EmailTester, $email);  
			return $test;  
		}  
	}  
	include("PHPLiveX.php");
 	$ajax = new PHPLiveX();  
  
	$myClass = new Validation();  
	$ajax->AjaxifyObjectMethods(array("myClass" => array("validateEmail")));  

  
	$ajax->Run(); // Must be called inside the 'html' or 'body' tags     	
	
	echo "SCRIPT SUCCESSFUL!";
?>  