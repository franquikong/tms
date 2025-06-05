<?php    
include 'inc/dbcon.php';

	if (isset($_POST["id"])) { 
		$tenant_id = $_POST['id'];
		$ebill_date = $_POST['ebill_date'];	
		$ebill_orno = $_POST['ebill_orno'];
		$ebill_part = $_POST['ebill_part'];
		$ebill_period = $_POST['ebill_period'];
		$ebill_newread = $_POST['ebill_newread'];
		$ebill_prevread = $_POST['ebill_prevread'];
		$ebill_cons = $_POST['ebill_cons'];
		$ebill_amount = $_POST['ebill_amount'];
		$ebill_prevbal = $_POST['ebill_prevbal'];	
		$ebill_payment = $_POST['ebill_payment'];
		$ebill_newbal = $_POST['ebill_newbal'];
		
		$add = $conn->prepare("INSERT INTO ebills (tenant_id, ebill_date, ebill_orno, ebill_part, ebill_period, ebill_newread, ebill_prevread, ebill_cons, ebill_amount, ebill_prevbal, ebill_payment, ebill_newbal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$add->execute(array($tenant_id, $ebill_date, $ebill_orno, $ebill_part, $ebill_period, $ebill_newread, $ebill_prevread, $ebill_cons, $ebill_amount, $ebill_prevbal, $ebill_payment, $ebill_newbal));
	
		$count = $add->rowCount();
		if ($count > 0){
			$date = date('Y-m-d'); 
			$logs = $conn->prepare("INSERT INTO logs(tenant_id, action, date, tdate, part) VALUES (?, ?, ?, ?, ?)");
			$logs->execute(array($tenant_id, 6, $date, $ebill_date, $ebill_part));
		}
	}

header ('location:elecbills.php');

?>