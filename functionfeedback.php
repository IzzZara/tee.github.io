<?php 
require_once 'dbconnect.php';
function displayfeedback(){
	global $connect;
	$query = "select * from contact_messages";
	$result= mysqli_query($connect,$query);
	return $result;
}
?>