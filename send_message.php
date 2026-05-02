<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = mysqli_real_escape_string($conn, $_POST['sender_id']);
    $return_path = mysqli_real_escape_string($conn, $_POST['return_path']);
    $data_stream = mysqli_real_escape_string($conn, $_POST['data_stream']);

    $query = "INSERT INTO messages (sender_id, return_path, data_stream) 
            VALUES ('$sender_id', '$return_path', '$data_stream')";

    if (mysqli_query($conn, $query)) {
        echo "SUCCESS: DATA_STREAM_TRANSMITTED";
    } else {
        echo "ERROR: TRANSMISSION_FAILED";
    }
}
?>