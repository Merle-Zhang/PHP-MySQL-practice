<?php
session_start();

require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

$failure = false;
$notice = false;

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( strlen($_POST['make']) < 1 ) {
        $_SESSION['failure'] = 'Make is required';
        header('Location: add.php');
        return;
    } elseif ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
        $_SESSION['failure'] = "Mileage and year must be numeric";
        header('Location: add.php');
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']));
        $_SESSION['success'] = 'Record inserted';
        header('Location: view.php');
        return;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Merle c0d447b7 's Automobile Tracker</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo(htmlentities($_SESSION['name']));?></h1>
<?php
if ( isset($_SESSION['failure']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>
