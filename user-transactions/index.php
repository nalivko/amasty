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
echo '<p>1. Query: "SELECT p.id, p.fullname, t1.from_person_id, SUM(t1.amount) as minus, t3.to_person_id, t3.plus, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id GROUP BY p.id "</p>';
foreach($connection->query('SELECT p.id, p.fullname, t1.from_person_id, SUM(t1.amount) as minus, t3.to_person_id, t3.plus, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance
 FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id
  LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id 
  GROUP BY p.id', PDO::FETCH_ASSOC) as $row) {
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



