<?php
session_start();

require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :autos_id");
$stmt->execute(array(":autos_id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for id';
    header( 'Location: index.php' ) ;
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Merle c0d447b7 's Deleting...</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>
<form method="post"><input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>"> <input type="submit" value="Delete" name="delete"><a href="index.php">Cancel</a>
</form>
</div>
</body>
</html>
