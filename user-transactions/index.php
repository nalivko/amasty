<?php

$host = "localhost";
$db_name = "testbase";
$username = "root";
$password = "";

$connection = null;

try {
    $connection = new PDO("mysql:host=".$host.";dbname=".$db_name, $username, $password);
    $connection->exec("set names utf8");
} catch(PDOException $exception) {
    echo "Connection errors: ".$exception->getMessage();
}

//foreach($connection->query('SELECT MAX(tb1.count) from (SELECT from_person_id, COUNT(*) as count from transactions GROUP BY from_person_id) tb1', PDO::FETCH_ASSOC) as $row) {
//    echo '<pre>';
//    print_r($row);
//    echo '</pre>';
//}



echo '<table><tr><td>Fullname</td><td>Balance</td></tr>';
echo '<p>1. Query: "SELECT p.id , p.fullname , (100 - SUM(t.amount)) as balance FROM persons p RIGHT JOIN  transactions t ON p.id = t.from_person_id GROUP BY t.from_person_id"</p>';
foreach($connection->query('SELECT p.id , p.fullname , (100 - SUM(t.amount)) as balance FROM persons p RIGHT JOIN  transactions t ON p.id = t.from_person_id GROUP BY t.from_person_id', PDO::FETCH_ASSOC) as $row) {
    echo '<tr>';
    echo '<td>'. $row['fullname'] .'</td>';
    echo '<td>' . $row['balance'] . '</td>';
    echo '</tr>';
}
echo '</table>';

foreach($connection->query('SELECT p.fullname, total FROM (SELECT from_person_id, total FROM 
(SELECT `from_person_id`, COUNT(*) as total FROM `transactions` LEFT JOIN (SELECT `to_person_id` FROM `transactions`)
 tb1 ON transactions.from_person_id = tb1.to_person_id GROUP BY from_person_id) tb2 WHERE total = 
 ((SELECT MAX(tb4.total) FROM (SELECT `from_person_id`, COUNT(*) as total FROM `transactions` LEFT JOIN 
 (SELECT `to_person_id` FROM `transactions`) tb3 ON transactions.from_person_id = tb3.to_person_id GROUP BY from_person_id) tb4)))
  tb5 JOIN persons p ON tb5.from_person_id = p.id ', PDO::FETCH_ASSOC) as $row) {
    echo '<pre>';
    echo $row['fullname'] . ' Total transactions:' . $row["total"];
    echo '</pre>';
}



