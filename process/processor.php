<?php 
include 'conn.php';
include 'conn2.php';
include 'conn3.php';
include 'conn4.php';

include 'remote.php'; // Remote / Client PC Info

$ip = $_SESSION['ip'];
$pc_name = $_SESSION['pc_name'];

$method = $_POST['method'];

if ($method == 'check_insert') {
	$line_no = $_POST['line_no'];
	$kanban_no = $_POST['kanban_no'];
	$location = $_POST['location'];
	//$ip = $_POST['ip'];
	//$pc_name = $_POST['pc_name'];

	$check = "SELECT id FROM location WHERE location = '$location'";
	$stmt = $conn->prepare($check);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		//FETCH E KANBAN MM MASTERLIST IF EXISTING
		$stmt = NUll;
		$query = "SELECT id FROM mm_masterlist WHERE kanban_qrcode = '$kanban_no'";
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		if ($stmt->fetchColumn() > 0) {
			$stmt = NULL;
			$get_details = "SELECT DISTINCT line_number,partscode,partsname,quantity,kanban_number,kanban_qrcode FROM mm_masterlist WHERE kanban_qrcode = '$kanban_no'";
			$stmt = $pdo->prepare($get_details);
			$stmt->execute();
			foreach($stmt->fetchALL() as $j){
			  $line_number = $j['line_number'];
			  $partscode = $j['partscode'];
			  $partsname = $j['partsname'];
			  $quantity = $j['quantity'];
			  $kanban_number = $j['kanban_number'];
			  $kanban_qrcode = $j['kanban_qrcode'];
			  $stmt = NULL;

			  $checks = "SELECT id FROM mm_inventory WHERE kanban_qr = '$kanban_qrcode' AND kanban_number = '$kanban_number'";
			  $stmt = $conn->prepare($checks);
			  $stmt->execute();
			  if ($stmt->rowCount() > 0) {
			  		echo 'duplicate';
			  }else{
			  	$stmt = NULL;
			  	  $insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_number`,`kanban_qr`,`scan_date_time`,`kanban_type`,`kanban_line_no`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$line_no','$partscode','$partsname','$quantity','$kanban_number','$kanban_qrcode','$server_date_time','MM','$line_number','$location','$ip','$pc_name','FINAL')";
				  $stmt = $conn->prepare($insert);
				  if ($stmt->execute()) {
				  		echo 'success';
				  		$stmt = NULL;
				  }else{
				  		echo 'error'; 
				  		$stmt = NULL;
				  }
			  }
			 
			}
		}else{
			$stmt = NULL;
			//FETCH TUBE CUTTING MASTERLIST IF EXISTING
			$tc_check = "SELECT id FROM tc_kanban_masterlist WHERE kanban = '$kanban_no'";
			$stmt = $conn3->prepare($tc_check);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				$stmt = NULL;
				$query = "SELECT kanban,kanban_no,line_no,length,parts_code,parts_name,quantity FROM tc_kanban_masterlist WHERE kanban = '$kanban_no'";
				$stmt = $conn3->prepare($query);
				$stmt->execute();
				foreach($stmt->fetchALL() as $j){
					$tc_kanban = $j['kanban'];
					$tc_kanban_no = $j['kanban_no'];
					$tc_line_no = $j['line_no'];
					$tc_length = $j['length'];
					$tc_parts_code = $j['parts_code'];
					$tc_parts_name = $j['parts_name'];
					$tc_quantity = $j['quantity'];
					$stmt = NULL;

					if($line_no == 'TUBE CUTTING'){
						$tc_checks = "SELECT id FROM mm_inventory WHERE kanban_qr = '$tc_kanban' AND kanban_number = '$tc_kanban_no' AND line_number = '$line_no'";
						$stmt = $conn->prepare($tc_checks);
						$stmt->execute();
						if ($stmt->rowCount() > 0) {
							echo 'duplicate';
						}else{
							$stmt = NULL;

							$tc_insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_number`,`kanban_qr`,`scan_date_time`,`kanban_type`,`kanban_line_no`,`length`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$line_no','$tc_parts_code','$tc_parts_name','$tc_quantity','$tc_kanban_no','$tc_kanban','$server_date_time','TC','$tc_line_no','$tc_length','$location','$ip','$pc_name','FINAL')";
							$stmt = $conn->prepare($tc_insert);
							if ($stmt->execute()) {
								echo 'success';
								$stmt = NULL;
							}else{
								echo 'error';
								$stmt = NULL;
							}
						}
					}else{
						$tc_checks = "SELECT id FROM mm_inventory WHERE kanban_qr = '$tc_kanban' AND kanban_number = '$tc_kanban_no'";
						$stmt = $conn->prepare($tc_checks);
						$stmt->execute();
						if ($stmt->rowCount() > 0) {
							echo 'duplicate';
						}else{
							$stmt = NULL;

							$tc_insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_number`,`kanban_qr`,`scan_date_time`,`kanban_type`,`kanban_line_no`,`length`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$line_no','$tc_parts_code','$tc_parts_name','$tc_quantity','$tc_kanban_no','$tc_kanban','$server_date_time','TC','$tc_line_no','$tc_length','$location','$ip','$pc_name','FINAL')";
							$stmt = $conn->prepare($tc_insert);
							if ($stmt->execute()) {
								echo 'success';
								$stmt = NULL;
							}else{
								echo 'error';
								$stmt = NULL;
							}
						}

				}

				}

			}else{
				// FETCH TUBE MAKING MASTERLIST IF EXISTING
				$stmt = NULL; 
				$tcm_check = "SELECT id FROM kanban_masterlist WHERE qr_code = '$kanban_no'";
				$stmt = $conn4->prepare($tcm_check);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					$stmt = NULL;

					$tcm_get_details = "SELECT partcode,partname,packing_quantity,qr_code FROM kanban_masterlist WHERE qr_code = '$kanban_no'";
					$stmt = $conn4->prepare($tcm_get_details);
					$stmt->execute();
					foreach($stmt->fetchALL() as $j){
						$tcmpartcode = $j['partcode'];
						$tcmpartname = $j['partname'];
						$tcmpacking_quantity = $j['packing_quantity'];
						$tcmqr_code = $j['qr_code'];
						$stmt = NULL;

						$tcm_checks = "SELECT id FROM mm_inventory WHERE kanban_qr = '$tcmqr_code'";
						$stmt = $conn->prepare($tcm_checks);
						$stmt->execute();
						if ($stmt->rowCount() > 0) {
							echo 'duplicate';
						}else{
							$stmt = NULL;
							$tcm_insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_qr`,`scan_date_time`,`kanban_type`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$line_no','$tcmpartcode','$tcmpartname','$tcmpacking_quantity','$tcmqr_code','$server_date_time','TM','$location','$ip','$pc_name','FINAL')";
							$stmt = $conn->prepare($tcm_insert);
							if ($stmt->execute()) {
								echo 'success';
								$stmt = NULL;
							}else{
								echo 'error';
								$stmt = NULL;
							}
						}

					}	


				}else{
					$stmt = NULL;
					echo '';

				}
			}
		}
	}else{
		echo 'invalid line number';
	}
}

if ($method == 'prev_scanned') {
	$line_no = $_POST['line_no'];
	$section = $_POST['section'];
	$c = 0;
	$query = "SELECT * FROM mm_inventory WHERE location = '$line_no' AND line_number = '$section' AND inventory_type = 'FINAL' ORDER BY id DESC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){	
		$c++;
		echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#edit_qty" onclick="get_inventory_details(&quot;'.$j['id'].'~!~'.$j['line_number'].'~!~'.$j['partscode'].'~!~'.$j['partsname'].'~!~'.$j['quantity'].'&quot;)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$j['id'].'</td>';
			echo '<td>'.$j['line_number'].'</td>';
			echo '<td>'.$j['partscode'].'</td>';
			echo '<td>'.$j['partsname'].'</td>';
			echo '<td>'.$j['quantity'].'</td>';
			echo '<td>'.$j['quantity'].'</td>';
			echo '<td>'.$j['length'].'</td>';
		echo '</tr>';	
		}
	}else{
		echo '<tr>';
			echo '<td colspan="8" style="text-align:center; color:red;">No Result !!!</td>';
		echo '</tr>';
	}
}

if ($method == 'update_qty') {
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$query = "UPDATE mm_inventory SET quantity = '$qty' WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}

if ($method == 'fetch_scanned') {
	$line_no = $_POST['line_no'];
	$location = $_POST['location'];
	$parts_code = $_POST['parts_code'];
	$c = 0;
	$query = "SELECT * FROM mm_inventory WHERE location LIKE '$location%' AND line_number LIKE '$line_no%' AND partscode LIKE '$parts_code%' AND inventory_type = 'FINAL'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){
		$c++;
		echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#edit_final_verified_qty" onclick="get_inventory_details_final_verified(&quot;'.$j['id'].'~!~'.$j['line_number'].'~!~'.$j['partscode'].'~!~'.$j['partsname'].'~!~'.$j['verified_qty'].'&quot;)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$j['id'].'</td>';
			echo '<td>'.$j['line_number'].'</td>';
			echo '<td>'.$j['partscode'].'</td>';
			echo '<td>'.$j['partsname'].'</td>';
			echo '<td>'.$j['quantity'].'</td>';
			echo '<td>'.$j['verified_qty'].'</td>';
			echo '<td>'.$j['length'].'</td>';
			echo '<td>'.strtoupper($j['location']).'</td>';
		echo '</tr>';
		}
	}else{
		echo '<tr>';
			echo '<td colspan="9" style="text-align:center; color:red;">No Result !!!</td>';
		echo '</tr>';
	}
}

if ($method == 'update_qty_final_verified') {
	$id = $_POST['id'];
	$qty = $_POST['qty'];
	$query = "UPDATE mm_inventory SET verified_qty = '$qty' WHERE id = '$id'";
	$stmt = $conn->prepare($query);
	if ($stmt->execute()) {
		echo 'success';
	}else{
		echo 'error';
	}
}

if ($method == 'get_section_final') {
	$query = "SELECT section FROM location GROUP BY section ORDER BY section ASC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="">Select Section</option>';
		foreach($stmt->fetchALL() as $j){
			echo '<option value="'.$j['section'].'">'.$j['section'].'</option>';
		}
	}
}

if ($method == 'get_location_final') {
	$section = $_POST['section'];
	$query = "SELECT location FROM location WHERE section = '$section'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="">Select Location</option>';
		foreach($stmt->fetchALL() as $j){
			echo '<option value="'.$j['location'].'">'.$j['location'].'</option>';
		}
	}
}
$conn = NULL;
$pdo = NULL; 
$conn3 = NULL;
$conn4 = NULL;
?>