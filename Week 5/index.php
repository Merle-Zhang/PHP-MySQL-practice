<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Merle c0d447b7's Index Page</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to the Automobiles Database</h1>
<?php
if ( !isset($_SESSION['name']) ) {
    echo '<p><a href="login.php">Please log in</a></p>'."\n";
    echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>'."\n";
} else {
    require_once "pdo.php";
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
    $stmt = $pdo->query("SELECT * FROM autos");
    if ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo('<table border="1">'."\n");
        echo('<thead><tr>'."\n");
        echo('<th>Make</th>'."\n");
        echo('<th>Model</th>'."\n");
        echo('<th>Year</th>'."\n");
        echo('<th>Mileage</th>'."\n");
        echo('<th>Action</th>'."\n");
        echo('</tr></thead>'."\n");
        do {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>\n");
        } while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) );
        echo('</table>'."\n");
    } else {
        echo('<p>No rows found</p>'."\n");
    }
    echo('<p><a href="add.php">Add New Entry</a></p>'."\n");
    echo('<p><a href="logout.php">Logout</a></p>'."\n");
    echo('<p>'."\n");
    echo('<b>Note:</b> Your implementation should retain data across multiple '."\n");
    echo('logout/login sessions.  This sample implementation clears all its'."\n");
    echo('data on logout - which you should not do in your implementation.'."\n");
    echo('</p>'."\n");
}
?>
</div>
</body>

