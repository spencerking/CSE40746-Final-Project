<?php
    // Start a session
    session_start();

    // Connect to the database
    $conn = oci_connect('guest', 'guest', 'localhost/XE');
    if (!$conn) {
    	$e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Get the variables
    $iid = $_GET['iid'];
    $fav_status = $_GET['fav'];

    $query1 = "SELECT COUNT(*) c FROM favorite WHERE item_id=$iid AND user_id=".$_SESSION['user_id'];
    $stmt1 = oci_parse($conn, $query1);
    oci_define_by_name($stmt1,"C", $fav_count);
    oci_execute($stmt1);
    oci_fetch($stmt1);

	if ($fav != 2)
	{
	    if ($fav_count > 0)
	    {
	        // Modify the favorite
	        // Insert the favorite
	        $query3 =  "UPDATE favorite ";
	        $query3 .= "SET status=$fav_status ";
	        $query3 .= "WHERE item_id=$iid";
	        $stmt3 = oci_parse($conn, $query3);
	        $r = oci_execute($stmt3);
	        // Error checking
	        if (!$r) 
	        {
	            $e = oci_error($stmt3);  // For oci_execute errors pass the statement handle
	            print htmlentities($e['message']);
	            print "\n<pre>\n";
	            print htmlentities($e['sqltext']);
	            printf("\n%".($e['offset']+1)."s", "^");
	            print  "\n</pre>\n";
	        }
	    }
	    else
	    {
	        // Insert the favorite
	        $query2 =  "INSERT INTO favorite (user_id, item_id, status) ";
	        $query2 .= "VALUES (".$_SESSION['user_id'].", $iid, $fav_status)";
	        $stmt2 = oci_parse($conn, $query2);
	        $r = oci_execute($stmt2);
	        // Error checking
	        if (!$r) 
	        {
	            $e = oci_error($stmt2);  // For oci_execute errors pass the statement handle
	            print htmlentities($e['message']);
	            print "\n<pre>\n";
	            print htmlentities($e['sqltext']);
	            printf("\n%".($e['offset']+1)."s", "^");
	            print  "\n</pre>\n";
	        }
	    }
	}
	else if ($fav == 2)
	{
		// Remove any favorite listing
	}
    // We don't need SQL anymore, shut it down
    oci_close($conn);

    header("Location: item.php?iid=$iid");

?>
