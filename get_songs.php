<?php
include('config.php');

if (isset($_GET['emotion'])) {
    $emotion = $_GET['emotion'];

    // Fetch songs related to the selected emotion
    $sql = "SELECT sid, albumtitle, song, artist FROM music WHERE emotion=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emotion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<ul class="list-group">';
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-group-item">' . $row['albumtitle'] . ' - ' . $row['song'] . ' (' . $row['artist'] . ')</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No songs found for this emotion.</p>';
    }
}
