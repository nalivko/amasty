<?php

$c = 'f';

if (!empty($_POST['bills']) && !empty($_POST['sum'])) {
    $bills = $_POST['bills'];
    $sum = $_POST['sum'];

    if (intval($sum) == 0) {
        echo json_encode(['result' => 'error', 'error' => 'Введите корректную сумму']);
        die();
    }

    $billsArr = explode(',', $bills);
    rsort($billsArr);
    $resultArr = [];

    foreach ($billsArr as $bill) {
        if (intval($bill) == 0) {
            echo json_encode(['result' => 'error', 'error' => 'Введите корректный номинал купюр']);
            die();
        }
        $resultArr[intval($bill)] = floor($sum / $bill);
        $sum -= $resultArr[intval($bill)] * $bill;
    }
    if ($sum != 0) {
        $min = $_POST['sum'] - $sum;
        $max = $_POST['sum'] + min($billsArr) - $sum;
        echo json_encode(['result' => 'warn', 'warn' => 'Неверная сумма. Выберите '.$min.' или '.$max]);
        die();
    }

    echo json_encode(['result' => 'complete', 'bills' => $resultArr]);
    die();
} else {
    echo json_encode(['result' => 'error', 'error' => 'Введите корректные данные']);
    die();
}


