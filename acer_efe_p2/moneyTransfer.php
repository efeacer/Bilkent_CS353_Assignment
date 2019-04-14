<?php
require 'ConnectionFactory.class.php';
$conn = ConnectionFactory::getConnection();

session_start();
$cid = $_SESSION['cid'];

$query = "SELECT name
          FROM customer
          WHERE cid = '$cid'";
$result = $conn->query($query) or die('Error in query: ' . $conn->error);
$data = $result->fetch_assoc();
$name = $data['name'];

echo '<h1>MONEY TRANSFER</h1>';

$query = "SELECT aid, branch, balance, openDate
          FROM account NATURAL JOIN owns
          WHERE cid = '$cid'";
$result = $conn->query($query) or die('Error in query: ' . $conn->error);

$sourceSelect = "<br><br> Source Account: <br> <select name='source' required>
                 <option value=''>None</option>";
$table = '<table>';
$table .= "<caption>Accounts of $name:</caption>";
$table .= '<tr> <th>aid</th> <th>branch</th> <th>balance</th>';
$table .= '<th>openDate</th> </tr>';
while ($row = $result->fetch_assoc()) {
    $table .= '<tr>';
    $aid = $row['aid'];
    $table .= '<td>' . $aid . '</td>';
    $table .= '<td>' . $row['branch'] . '</td>';
    $table .= '<td>' . $row['balance'] . ' TL' . '</td>';
    $table .= '<td>' . $row['openDate'] . '</td>';
    $sourceSelect .= "<option value='$aid'>$aid</option>";
    $table .= '</tr>';
}
$table .= '</table>';
$sourceSelect .= '</select><br>';
echo $table;

$query = 'SELECT aid, name, branch, balance, openDate
          FROM (account NATURAL JOIN owns) NATURAL JOIN customer';
$result = $conn->query($query) or die('Error in query: ' . $conn->error);

$destSelect = "Destination Account: <br> <select name='dest' required>
               <option value=''>None</option>";
$table = '<br><table>';
$table .= "<caption>All accounts:</caption>";
$table .= '<tr> <th>aid</th> <th>owner</th> <th>branch</th> <th>balance</th>';
$table .= '<th>openDate</th> </tr>';
while ($row = $result->fetch_assoc()) {
    $table .= '<tr>';
    $aid = $row['aid'];
    $owner = $row['name'];
    $table .= '<td>' . $aid . '</td>';
    $table .= '<td>' . $owner . '</td>';
    $table .= '<td>' . $row['branch'] . '</td>';
    $table .= '<td>' . $row['balance'] . ' TL' . '</td>';
    $table .= '<td>' . $row['openDate'] . '</td>';
    $destSelect .= "<option value='$aid'>$aid, $owner</option>";
    $table .= '</tr>';
}
$table .= '</table>';
$destSelect .= '</select><br> Transfer amount: <br>';
echo $table;

$amount = "<input type='text' id='amountInput' name='amount' pattern='[0-9]*'
           placeholder='numeric inputs only' required>";
$submit = "<br> <button type='submit'>Transfer</button>";

echo "<form method='post' action='performTransfer.php'" . $sourceSelect .
     $destSelect . $amount . $submit . '</form>';
echo "<a href='welcome.php'>Back to Welcome Page</a>
      <br> <a href='index.php'>Logout</a>";
?>

<!doctype html>
<html>
    <head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css'
              href='http://fonts.googleapis.com/css?family=Spectral'>
        <title>ACER BANK</title>
    </head>
        <style>
        * {
           font-family: Spectral;
           font-size: 20px;
           text-align: center;
        }
        h1 {
            font-size: 40px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
        }
        caption {
            text-align: left;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #a5a5a5;
            color: white;
        }
        tr:nth-child(odd) {
            background-color: #dddddd;
        }
        tr:hover {
            background-color: #fdfd96;
        }
        select {
            margin-bottom: 10px;
        }
        input {
            width: 200px;
            margin-bottom: 10px;
            border-radius: 10px;
        }
        button {
            width: 150px;
            margin-top: 10px;
            border-radius: 10px;
            background-color: #4CAF50;
            color: white;
        }
        button:hover {
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),
                        0 17px 50px 0 rgba(0,0,0,0.19);
        }
    </style>
</html>
