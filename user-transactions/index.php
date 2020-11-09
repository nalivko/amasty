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
echo '<p>1. Query: "SELECT p.fullname, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id GROUP BY p.id, t3.plus "</p>';
foreach($connection->query('SELECT p.fullname, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id GROUP BY p.id, t3.plus ', PDO::FETCH_ASSOC) as $row) {
    echo '<tr>';
    echo '<td>'. $row['fullname'] .'</td>';
    echo '<td>' . $row['balance'] . '</td>';
    echo '</tr>';
}
echo '</table>';

foreach($connection->query('SELECT result.fullname, result.transactionsSum as trCnt FROM
(SELECT p.id, p.fullname, t1.cnt1, t2.cnt2, (IFNULL(t1.cnt1, 0) + IFNULL(t2.cnt2, 0)) as transactionsSum FROM persons p
 LEFT JOIN (SELECT t.from_person_id, COUNT(from_person_id) as cnt1 FROM transactions t GROUP BY t.from_person_id) t1 ON p.id = t1.from_person_id
 LEFT JOIN (SELECT t.to_person_id, COUNT(to_person_id) as cnt2 FROM transactions t GROUP BY t.to_person_id) t2 ON p.id = t2.to_person_id) result
 ORDER BY trCnt DESC
 LIMIT 1', PDO::FETCH_ASSOC) as $row) {
    echo '<pre>';
    echo $row['fullname'] . ' - Total transactions:' . $row["trCnt"];
    echo '</pre>';
}



