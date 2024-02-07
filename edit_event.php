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
        <h2>Izmjena </h2>
    

        <?php $event_id=$_GET['event_id']?>

        <form action="action.php" method="GET">
            Event name <input type="text" name="event_name" value="<?php echo $_GET['event_id']?>"/><br/>
            event_start_date <input type="text" name="event_start_date" value="<?php echo $_GET['event_start_date']?>"/><br/>
            <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']?>" />
            <input type="hidden" name="action" value="action_event_edit_u_bazi"/>
            <input type="submit" name="Submit" value="Unesi"/> 
        </form>
    </body>
</html>
