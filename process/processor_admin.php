<?php 
include 'conn.php';

$method = $_POST['method'];

if ($method == 'fetch_inventory') {
	$c = 0;
	$query = "SELECT * FROM mm_inventory";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach($stmt->fetchALL() as $j){
			$c++;
			echo '<tr>';
				echo '<td>'.$c.'</td>';
				echo '<td>'.$j['id'].'</td>';
				echo '<td>'.$j['location'].'</td>';
				echo '<td>'.$j['partscode'].'</td>';
				echo '<td>'.$j['partsname'].'</td>';
				echo '<td>'.$j['quantity'].'</td>';
				echo '<td>'.$j['verified_qty'].'</td>';
				echo '<td>'.$j['length'].'</td>';
				echo '<td>'.$j['line_number'].'</td>';
			echo '</tr>';
		}
	}
}
?>