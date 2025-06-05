<?php
	include 'inc/dbcon.php';

	class view
	{
		
		public function ebills($id)
		{
			global $conn;
			$sql = $conn->prepare('	SELECT * FROM tenants 
									LEFT JOIN  stalls ON  stalls.stall_id = tenants.stall_id
									LEFT JOIN (Select * from ebills where ebill_id in (select max(ebill_id) from ebills group by tenant_id)) e on e.tenant_id = tenants.tenant_id
									LEFT JOIN rate ON rate.rate_id = tenants.rate_id
									WHERE rate.rate_id = ? AND tenants.tenant_id = ? ORDER BY stall_number');
			$sql->execute(array(1,$id));
			$count = $sql->rowCount();
			$fetch = $sql->fetch();
			if($count > 0){
				echo 'Name: '.$fetch['tenant_fname']." ".$fetch['tenant_lname'].'/'.
					'Stall: ' .$fetch['stall_number'].'/'.
					'Meter: ' .$fetch['meter_number'].'/'.
					$fetch['elec_rate'].'/'.
					$fetch['ebill_newread'].'/'.
					$fetch['ebill_newbal'];
			}else{
				echo '0';
			}
		}
        public function rentals($tenant_id)
        {
            global $conn;
            $sql = $conn->prepare(' SELECT * FROM tenants 
                                    LEFT JOIN stalls ON stalls.stall_id = tenants.stall_id
                                    WHERE tenants.tenant_id = ?');
            $sql->execute(array($tenant_id));
            $count = $sql->rowCount();
            $fetch = $sql->fetch();
            if ($count > 0) {
                echo json_encode([
                    'name' => $fetch['tenant_fname'] . " " . $fetch['tenant_lname'],
                    'stall' => $fetch['stall_number'],
                    'rent' => $fetch['rent_amount']
                ]);
            } else {
                echo '0';
            }
        }
    }

    $myview = new view();
    $key = $_POST['key'];

    switch ($key) {
        case 'add_ebills':
            $id = $_POST['id'];
            $myview->ebills($id);
            break;
        case 'add_rentals':
            $tenant_id = $_POST['tenant_id'];
            $myview->rentals($tenant_id);
            break;
    }

?>