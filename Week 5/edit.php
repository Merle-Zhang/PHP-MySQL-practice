<?php
session_start();

require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}

if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model']) && isset($_POST['autos_id']) ) {
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } elseif ( !is_numeric($_POST['year']) ) {
        $_SESSION['error'] = "Year must be numeric";
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } elseif ( !is_numeric($_POST['mileage']) ) {
        $_SESSION['error'] = "Mileage must be numeric";
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } else {
        $sql = "UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':md' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']));
        $_SESSION['success'] = 'Record added';
        header('Location: index.php');
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :autos_id");
$stmt->execute(array(":autos_id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}

$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Merle c0d447b7 's Automobile Tracker</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Editing Automobile</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="post">
<p>Make<input type="text" name="make" size="40" value="<?= $mk ?>"/></p>
<p>Model<input type="text" name="model" size="40" value="<?= $md ?>"/></p>
<p>Year<input type="text" name="year" size="10" value="<?= $yr ?>"/></p>
<p>Mileage<input type="text" name="mileage" size="10" value="<?= $mi ?>"/></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>
