<?php
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

$get_sector = mysqli_query($db,"SELECT * FROM  sectors WHERE districtcode ='".$_POST['districtcode']."'");

	echo "<select name=\"sectorcode\" id=\"sectorcode\" class=\"form-control\">";
	if(mysqli_fetch_array($get_sector)==0){
		echo "<option value=\"No Sector Available\">No Sector Available</option>";
	}else{
	
	        echo "<option value=\"\">------Select sector------</option>";
		while($row=mysqli_fetch_array($get_sector)){
			echo "<option value=\"".$row['sectorcode']."\">".$row['namesector']."</option>";
		}
	}
	echo "</select><br>";
