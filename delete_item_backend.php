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
	$sid = $_GET['sid'];

	if ($sid == $_SESSION['user_id'])
	{
		$query = "DELETE FROM item WHERE item_id=$iid";
		$stmt = oci_parse($conn, $query);

		$r = oci_execute($stmt);

            // error catching
            if (!$r) 
            {
                $e = oci_error($stmt);  // For oci_execute errors pass the statement handle
                print htmlentities($e['message']);
                print "\n<pre>\n";
                print htmlentities($e['sqltext']);
                printf("\n%".($e['offset']+1)."s", "^");
                print  "\n</pre>\n";
            }
	}

	// We don't need SQL anymore, shut it down
	oci_close($conn);

	header("Location: home.php?c=9");

?>
