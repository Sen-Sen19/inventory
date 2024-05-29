<?php 
include 'conn2.php';
include 'conn.php';
include 'conn4.php';
include 'oracle.php';

include 'remote.php'; // Remote / Client PC Info

$ip = $_SESSION['ip'];
$pc_name = $_SESSION['pc_name'];

$method = $_POST['method'];

if ($method == 'check_insert') {
	$kanban_no = $_POST['kanban_no'];
	$location_initial = $_POST['location'];
	//$ip = $_POST['ip'];
	//$pc_name = $_POST['pc_name'];
	$section = $_POST['section'];

	$query = "SELECT id FROM location_initial WHERE machine_no = '$location_initial'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		$stmt = NULL;
		$query = "SELECT id FROM mm_masterlist WHERE kanban_qrcode = '$kanban_no'";
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		if ($stmt->fetchColumn() > 0) {
			// Revisions (Vince)

			// WT KANBAN IF FOUND ON MASTERLIST
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
			  	  $insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_number`,`kanban_qr`,`scan_date_time`,`kanban_type`,`kanban_line_no`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$location_initial','$partscode','$partsname','$quantity','$kanban_number','$kanban_qrcode','$server_date_time','MM','$line_number','$section','$ip','$pc_name','INITIAL')";
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
			// FETCH TUBE MAKING MASTERLIST IF EXISTING
				$stmt = NULL; 
				$tcm_check = "SELECT id FROM kanban_masterlist WHERE qr_code = '$kanban_no'";
				$stmt = $conn4->prepare($tcm_check);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					echo '';

				}else{
					// FETCH FSIB ORACLE FOR INITIAL KANBAN
					$stmt = NULL;
					$kanban_no = strtoupper($kanban_no);
					$location = substr($kanban_no, 5,4); //Location
				    $parts_code = substr($kanban_no, 13,20); //Parts Code
				    $parts_code = trim($parts_code); //Parts Code
				    $line_nos = substr($kanban_no, 37,10); //Line No
			    	$line_noss = trim($line_nos); //Line No
			    	$kanban_num = substr($kanban_no, 33,4); //Kanban No
			    	$kanban_num = ltrim($kanban_num, '0'); //Kanban No
					//FETCH DATA FSIB
				    $query = "SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_KNYSAKBHNNAM,NVL(C_BANTICODE,'No Data') AS C_BANTICODE,C_KNYSAKBHNNAM 
			        FROM(SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
			            FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO, A.C_DSNSTRIPE,A.C_TKSSENCOD,C.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
			            RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
			            FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
			            WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
			            AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD = '$location' 
			            ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1
			            UNION ALL SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,BB.C_BANTICODE,C_KNYSAKBHNNAM
			            FROM(SELECT C_BHNSZICOD,C_BHNSZINAM,C_DSNSIZ,C_DSNJIIRO,C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,NULL AS C_BANTICODE,C_KNYSAKBHNNAM
			                FROM (
			                    SELECT A.C_BHNSZICOD,A.C_BHNSZINAM,A.C_DSNSIZ,A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,NULL AS C_BANTICODE,A.C_KNYSAKBHNNAM,RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.C_KNYSAKCOD) AS RANKING 
			                    FROM M_ZAIBHNSZIMST A WHERE NOT EXISTS(SELECT 1 FROM (SELECT C_BHNSZICOD, C_BHNSZINAM, C_DSNSIZ, C_DSNJIIRO, C_DSNSTRIPE,C_TKSSENCOD,L_MINLOTSUU,C_KNYSAKCOD,C_BANTICODE,C_KNYSAKBHNNAM 
			                    FROM (SELECT A.C_BHNSZICOD, A.C_BHNSZINAM, A.C_DSNSIZ, A.C_DSNJIIRO,A.C_DSNSTRIPE,A.C_TKSSENCOD,A.L_MINLOTSUU,A.C_KNYSAKCOD,B.C_BANTICODE,A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,C.C_KNYSAKBHNNAM ,
			                    RANK() OVER(PARTITION BY A.C_BHNSZICOD ORDER BY A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD,B.C_BANTICODE) AS RANKING 
			                    FROM T_ZAIZIKMSI A LEFT JOIN M_BANTI B ON A.C_BHNSZICOD = B.C_BANTIBIKOU LEFT OUTER JOIN M_ZAIBHNSZIMST C ON A.C_BHNSZICOD = C.C_BHNSZICOD AND A.C_KNYSAKCOD = C.C_KNYSAKCOD 
			                    WHERE NVL(A.C_ZAKSTATUS,'00') = '00' AND NVL(B.C_BANTIKUBUN,'1') = '1' AND NVL(B.C_HIKIATEFLAG,'1') = '1' AND TO_CHAR(NVL(B.DT_STARTYMD,SYSDATE),'YYYY/MM/DD') <= TO_CHAR(SYSDATE,'YYYY/MM/DD') AND TO_CHAR(NVL(B.DT_ENDYMD,SYSDATE),'YYYY/MM/DD') >= TO_CHAR(SYSDATE,'YYYY/MM/DD') 
			                    AND A.C_CNTFLG = '0' AND A.C_PLTFLG = '0' AND A.C_BNTFLG = '1' AND A.C_LOCCOD = '$location' ORDER BY A.C_LOCCOD, A.C_BHNSZICOD, A.DT_ZAIKOTRKHIZ, A.C_NYKLBLBARCOD) WHERE RANKING = 1) B WHERE A.C_BHNSZICOD = B.C_BHNSZICOD)
			                ) WHERE RANKING = 1
					            ) AA LEFT OUTER JOIN M_BANTI BB ON AA.C_BHNSZICOD = BB.C_BANTIBIKOU WHERE AA.C_BHNSZICOD IS NOT NULL
					        )
					        WHERE C_BHNSZICOD = '$parts_code'
					        ";
					        $stmt = oci_parse($ora,$query);
			        		oci_execute($stmt);
			        		while($row=oci_fetch_assoc($stmt)){
				        	$parts_name = $row['C_BHNSZINAM'];
							$quantity = $row['L_MINLOTSUU'];
				        	$rows = oci_num_rows($stmt);
				        	if ($rows > 0) {
				        			//CHECK DUPLICATE DATA IN INVENTORY
		        	  		$checks = "SELECT id FROM mm_inventory WHERE kanban_qr = '$kanban_no' AND kanban_number = '$kanban_num'";
							  $stmt2 = $conn->prepare($checks);
							  $stmt2->execute();
							  if ($stmt2->rowCount() > 0) {
							  		echo 'duplicate';
							  }else{
							  	//INSERT DATA IN INVENTORY
							  	  $insert = "INSERT INTO mm_inventory (`line_number`,`partscode`,`partsname`,`quantity`,`kanban_number`,`kanban_qr`,`scan_date_time`,`kanban_type`,`kanban_line_no`,`location`,`ip_address`,`pc_name`,`inventory_type`)VALUES('$location_initial','$parts_code','$parts_name','$quantity','$kanban_num','$kanban_no','$server_date_time','MM','$line_noss','$section','$ip','$pc_name','INITIAL')";
								  $stmt3 = $conn->prepare($insert);
								  if ($stmt3->execute()) {
								  		echo 'success';
								  		$stmt3 = NULL;
								  }else{
								  		echo 'error'; 
								  		$stmt3 = NULL;
								  }
							  }
							  			oci_close($ora);
				        	}else{
				        		echo '';
				        				oci_close($ora);
				        	}

				        }

				}
		}
	}else{
		echo 'invalid location';
	}
}

if ($method == 'prev_scanned') {
	$location = $_POST['location'];
	$c = 0;
	$query = "SELECT * FROM mm_inventory WHERE line_number = '$location' AND inventory_type = 'INITIAL' ORDER BY id DESC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){	
		$c++;
		echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#edit_qty_initial" onclick="get_inventory_details_initial(&quot;'.$j['id'].'~!~'.$j['line_number'].'~!~'.$j['partscode'].'~!~'.$j['partsname'].'~!~'.$j['quantity'].'&quot;)">';
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

if ($method == 'update_qty_initial') {
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

if ($method == 'fetch_scanned_initial') {
	$location = $_POST['location'];
	$partscode = $_POST['partscode'];
	$section = $_POST['section'];
	$c = 0;
	$query = "SELECT * FROM mm_inventory WHERE line_number LIKE '$location%' AND inventory_type = 'INITIAL' AND partscode LIKE '$partscode%' AND location LIKE '$section%'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){
		$c++;
		echo '<tr style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#edit_initial_verified_qty" onclick="get_inventory_details_initial_verified(&quot;'.$j['id'].'~!~'.$j['line_number'].'~!~'.$j['partscode'].'~!~'.$j['partsname'].'~!~'.$j['verified_qty'].'&quot;)">';
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

if ($method == 'update_qty_initial_verified') {
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

if ($method == 'get_section') {
	$query = "SELECT location FROM location_initial GROUP BY location ORDER BY location ASC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="">Select Section</option>';
		foreach($stmt->fetchALL() as $j){
			echo '<option value="'.$j['location'].'">'.$j['location'].'</option>';
		}
	}
}

if ($method == 'get_location_name_initial') {
	$query = "SELECT machine_no FROM location_initial GROUP BY machine_no ORDER BY machine_no ASC";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		echo '<option value="">Select Location</option>';
		foreach($stmt->fetchALL() as $j){
			echo '<option value="'.$j['machine_no'].'">'.$j['machine_no'].'</option>';
		}
	}
}

if ($method == 'get_location') {
	$section = $_POST['section'];

	$query = "SELECT machine_no FROM location_initial WHERE location = '$section' GROUP BY machine_no";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		 echo '<option value="">Select Location</option>';
		foreach($stmt->fetchALL() as $x){
                echo '<option value="'.$x['machine_no'].'">'.$x['machine_no'].'</option>';	
            }
	}
}

$conn = NULL;
$pdo = NULL;
$ora = NULL;
?>