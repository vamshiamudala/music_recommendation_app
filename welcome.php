<?php
session_start();
include('config.php');

// Check if the user is logged in
if(!isset($_SESSION['loggedin'])){
    header('Location: index.php');
    exit;
}

// Fetch unique emotion types
$sql = "SELECT DISTINCT emotion FROM music";
$result = $conn->query($sql);
$emotion_types = [];
while($row = $result->fetch_assoc()) {
    $emotion_types[] = $row['emotion'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4">Welcome</h1>

    <div class="row">
        <?php foreach ($emotion_types as $emotion): ?>
            <div class="col-md-4">
                <div class="card mb-4" data-emotion="<?php echo $emotion; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $emotion; ?></h5>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" class="btn btn-danger" onclick="logout()">Logout</button>
</div>

<!-- Modal -->
<div class="modal fade" id="songListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Song List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="songList">
                <!-- Songs will be appended here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function logout() {
    window.location.href = 'logout.php';
}

function getSongs(emotion) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `get_songs.php?emotion=${emotion}`);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('songList').innerHTML = xhr.responseText;
            $('#songListModal').modal('show');
        }
    };
    xhr.send();
}

document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('click', () => {
        const emotion = card.getAttribute('data-emotion');
        getSongs(emotion);
    });
});
</script>

</body>
</html>

