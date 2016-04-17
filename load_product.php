<?php
	$conn = oci_connect("guest", "guest", "xe")
		or die("Couldn't connect");
	
	$query1 = "SELECT i.seller_id s, i.name n, i.condition c, i.description d, i.price p, i.end_time e ";
	$query1 .= "FROM item i ";
	$query1 .= "WHERE i.item_id=7";
	
	$stmt = oci_parse($conn, $query1);
	oci_define_by_name($stmt, "S", $s);
	oci_define_by_name($stmt, "N", $n);
	oci_define_by_name($stmt, "C", $c);
	oci_define_by_name($stmt, "D", $d);
	oci_define_by_name($stmt, "P", $p);
	oci_define_by_name($stmt, "E", $e);

	oci_execute($stmt);

	while (oci_fetch($stmt))
	{
		print "seller_id: $s<br/>";
		print "name: $n<br/>";
		print "condition: $c<br/>";
		print "description: $d<br/>";
		print "price: $p<br/>";
		print "end_time: $e<br/>";
	}

	oci_close($conn);
?>

