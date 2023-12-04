<?php
require "../sqlConnection/db_connect.php";

function deleteExpiredData() {
    global $conn;

    $sql = "DELETE FROM archived_stdinfo WHERE expiration < CURDATE();
            DELETE FROM archived_thrinfo WHERE expiration < CURDATE()
            DELETE FROM archived_userinfo WHERE expiration < CURDATE()";
    mysqli_query($conn, $sql);
}