<?php

$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
    $e oci_error();
    echo $e['message'];
    exit;
}

$query = 'SELECT * FROM item';
$stid = oci_parse($conn, $query);
$r = oci_execute($query);

print '<table>';
while ($row = oci_fetch_array($stid, OCI_RETURNS_NULL+OCI_ASSOC)) {
    print '<tr>';
    foreach ($row as $item) {
        print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp;').'</td>';
    }
    print '</tr>';
}
print '</table>';

oci_close($conn);

?>