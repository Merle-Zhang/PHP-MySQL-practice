<?php
session_start();

require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
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

if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>

<h2>Automobiles</h2>
<ul>
<p>
<?php
$stmt = $pdo->query("SELECT * FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo '<li><!-- '.($row['auto_id']-1).' -->';
    echo htmlentities($row['make'].' '.$row['year'].' / '.$row['mileage']);
    echo "\n";
}
?>
</ul>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</div>
</body>
</html>
