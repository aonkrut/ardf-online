<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARDF online</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script defer src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php 
    include 'navigation.php';
    include 'config.php';

    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];
    } else {
        $competition_id = "0";
    }

    $sql = "SELECT * FROM ardf_competition WHERE competition_id = '$competition_id'";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $event_id = $row['event_id'];
?>
<div class="container mt-2">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h4 class="mt-3 mb-2 d-inline">Natjecanje</h4>
                </div>
                <div class="card-body">
                <form action="action.php" method="post" id="eventForm">
    <div class="mb-3">
        <label for="competition_name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="competition_name" name="competition_name" value="<?php echo isset($row['competition_name']) ? $row['competition_name'] : ''; ?>" required>
    </div>
    
    <div class="row">
        <div class="col-sm-4 mb-2">
            <label for="competition_type" class="col-form-label">Competition Type</label>
            <?php
            include 'config.php';
            $sql2 = "SELECT * FROM ardf_type";
            $result2 = mysqli_query($mysqli, $sql2);

            if ($result2) {
                echo '<select class="form-select" id="competition_type" name="competition_type" required>';
                echo '<option value="" selected disabled>Odaberite vrstu natjecanja</option>';
                $selected_id = isset($row['competition_type_id']) ? $row['competition_type_id'] : '';
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $selected = ($selected_id == $row2['type_id']) ? 'selected' : '';
                    echo "<option value='" . $row2['type_id'] . "' $selected>" . $row2['type_name'] . "</option>";
                }
                echo '</select>';
                mysqli_free_result($result2);
            } else {
                echo "Error: " . $sql2 . "<br>" . mysqli_error($mysqli);
            }
            ?>
        </div>

        <div class="col-sm-4 mb-2">
            <label for="competition_start_date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="competition_start_date" name="competition_start_date" value="<?php echo isset($row['competition_start_date']) ? $row['competition_start_date'] : ''; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="competition_description" class="form-label">Description:</label>
        <textarea class="form-control" id="competition_description" name="competition_description" rows="2" required><?php echo isset($row['competition_description']) ? $row['competition_description'] : ''; ?></textarea>
    </div>

    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="competition_start_entry_date" class="form-label">Start Entry Date:</label>
            <input type="date" class="form-control" id="competition_start_entry_date" name="competition_start_entry_date" value="<?php echo isset($row['competition_start_entry_date']) ? $row['competition_start_entry_date'] : ''; ?>" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="competition_end_entry_date" class="form-label">End Entry Date:</label>
            <input type="date" class="form-control" id="competition_end_entry_date" name="competition_end_entry_date" value="<?php echo isset($row['competition_end_entry_date']) ? $row['competition_end_entry_date'] : ''; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="location" class="form-label">Location:</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo isset($row['competition_location']) ? $row['competition_location'] : ''; ?>" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="coordinates" class="form-label">Coordinates:</label>
            <input type="text" class="form-control" id="coordinates" name="coordinates" value="<?php echo isset($row['competition_coordinates']) ? $row['competition_coordinates'] : ''; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="competition_start_time" class="col-sm-3 col-form-label">Start Time:</label>
        <div class="col-sm-9">
            <input type="time" class="form-control" id="competition_start_time" name="competition_start_time" value="<?php echo isset($row['competition_start_time']) ? $row['competition_start_time'] : ''; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="gathering_time" class="col-sm-3 col-form-label">Gathering Time:</label>
        <div class="col-sm-9">
            <input type="time" class="form-control" id="gathering_time" name="gathering_time" value="<?php echo isset($row['gathering_time']) ? $row['gathering_time'] : ''; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="departure_to_start" class="col-sm-3 col-form-label">Departure to Start:</label>
        <div class="col-sm-9">
            <input type="time" class="form-control" id="departure_to_start" name="departure_to_start" value="<?php echo isset($row['departure_to_start']) ? $row['departure_to_start'] : ''; ?>" required>
        </div>
    </div>
    <div class="row mb-3">
        <label for="goniometer_delay" class="col-sm-3 col-form-label">Goniometer Delay:</label>
        <div class="col-sm-9">
            <input type="time" class="form-control" id="goniometer_delay" name="goniometer_delay" value="<?php echo isset($row['goniometer_delay']) ? $row['goniometer_delay'] : ''; ?>" required>
        </div>
    </div> 

    <div class="modal-footer">
        <a class="btn btn-secondary" href="admin_event.php?event_id=<?php echo $event_id;?>">Zatvori</a>
        
        <input type="hidden" name="competition_id" value="<?php echo $competition_id; ?>">
        <input type="hidden" name="update_competition_submit" value="1">
        <button type="submit" class="btn btn-success">Spremi</button>
    </div>
</form>

                </div>
            </div>
        </div>
    <?php }} ?>
</body>
</html>
