<?php
require 'ConnectionFactory.class.php';
$conn = ConnectionFactory::getConnection();

session_start();
$cid = $_SESSION['cid'];

$query = "SELECT name
          FROM customer
          WHERE cid = '$cid'";
$result = $conn->query($query);
$data = $result->fetch_assoc();
$name = $data['name'];

echo '<h1>WELCOME ' . strtoupper($name) . '</h1>';

$query = "SELECT aid, branch, balance, openDate
          FROM account NATURAL JOIN owns
          WHERE cid = '$cid'";
$result = $conn->query($query) or die('Error in query: ' . $conn->error);

$table = '<table>';
$table .= '<caption>Accounts:</caption>';
$table .= '<tr> <th>aid</th> <th>branch</th> <th>balance</th>';
$table .= '<th>openDate</th> <th>close</th> </tr>';
while ($row = $result->fetch_assoc()) {
    $table .= '<tr>';
    $aid = $row['aid'];
    $table .= '<td>' . $aid . '</td>';
    $table .= '<td>' . $row['branch'] . '</td>';
    $table .= '<td>' . $row['balance'] . ' TL' . '</td>';
    $table .= '<td>' . $row['openDate'] . '</td>';
    $table .= '<td>' . "<a href='closeAccount.php?aid=$aid'>close</a>";
    $table .= '</td> </tr>';
}
$table .= '</table>';
echo $table;
echo "<br> <a href='moneyTransfer.php'>Money Tansfer</a>
      <br> <a href='index.php'>Logout</a>";

$conn->close();
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
    </style>
</html>
