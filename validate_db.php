<?php
	$servername="localhost";
	$username="root";
	$serverPassword="";
	$DBname="ritma";
	$conn=mysqli_connect($servername, $username, $serverPassword, $DBname);
	mysqli_set_charset( $conn, 'utf8' );
	if(!$conn){
		die("Connection ERROR: ".mysqli_connect_error());
	}
	$sql="SELECT * FROM `words` ORDER BY `word` ASC";
	$result=mysqli_query($conn, $sql);
	$row=mysqli_fetch_assoc($result);
	while(mysqli_num_rows($result)>0){
		$temp=$row['word'];
	}
?>