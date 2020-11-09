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


echo '<h2>I</h2>';
echo '<table><tr><td>Fullname</td><td>Balance</td></tr>';
echo '<p>Query: "SELECT p.fullname, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id GROUP BY p.id, t3.plus "</p>';
foreach($connection->query('SELECT p.fullname, (100 - IFNULL(SUM(t1.amount), 0) + IFNULL(t3.plus, 0)) as balance FROM `persons` p LEFT JOIN transactions t1 ON p.id = t1.from_person_id LEFT JOIN (SELECT t2.to_person_id, SUM(t2.amount) as plus FROM persons p LEFT JOIN transactions t2 ON p.id = t2.to_person_id GROUP BY p.id) t3 ON p.id = t3.to_person_id GROUP BY p.id, t3.plus ', PDO::FETCH_ASSOC) as $row) {
    echo '<tr>';
    echo '<td>'. $row['fullname'] .'</td>';
    echo '<td>' . $row['balance'] . '</td>';
    echo '</tr>';
}
echo '</table>';


echo '<h2>II</h2>';
echo '<p>Query: "SELECT result.fullname, result.transactionsSum as trCnt FROM
(SELECT p.id, p.fullname, t1.cnt1, t2.cnt2, (IFNULL(t1.cnt1, 0) + IFNULL(t2.cnt2, 0)) as transactionsSum FROM persons p
 LEFT JOIN (SELECT t.from_person_id, COUNT(from_person_id) as cnt1 FROM transactions t GROUP BY t.from_person_id) t1 ON p.id = t1.from_person_id
 LEFT JOIN (SELECT t.to_person_id, COUNT(to_person_id) as cnt2 FROM transactions t GROUP BY t.to_person_id) t2 ON p.id = t2.to_person_id) result
 ORDER BY trCnt DESC
 LIMIT 1"</p>';
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

echo '<h2>III</h2>';
echo '<p>Query: "SELECT t.id, t1.fullname, t1.name, t2.fullname, t2.name FROM transactions t JOIN (SELECT p.id, p.fullname, c.name FROM persons p JOIN cities c ON p.city_id = c.id ) t1 ON t.from_person_id = t1.id JOIN (SELECT p.id, p.fullname, c.name FROM persons p JOIN cities c ON p.city_id = c.id ) t2 ON t.to_person_id = t2.id WHERE t1.name = t2.name "</p>';
foreach ($connection->query('SELECT t.id as trId, t1.fullname as name1, t1.name as city1 , t2.fullname as name2, t2.name as city2 FROM transactions t
JOIN 
	(SELECT p.id, p.fullname, c.name FROM persons p JOIN cities c ON p.city_id = c.id ) t1 ON t.from_person_id = t1.id
JOIN 
	(SELECT p.id, p.fullname, c.name FROM persons p JOIN cities c ON p.city_id = c.id ) t2 ON 		t.to_person_id = t2.id
WHERE t1.name = t2.name ', PDO::FETCH_ASSOC) as $row) {
    echo '<pre>';
    echo $row['trId'] . ' - ' . $row["name1"]. ' - ' . $row["city1"] . $row["name2"]. ' - ' . $row["city2"];
    echo '</pre>';
}



