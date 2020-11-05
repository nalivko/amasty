<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .stroop td {
            border: 1px solid black;
            padding: 3px 5px;
            font-size: 20px;
        }
    </style>
</head>
<body>

</body>
</html>

<?php

$colors = ['red', 'blue', 'green', 'yellow', 'lime', 'magenta', 'black', 'gold', 'gray', 'tomato'];

//echo $colors[rand(0,9)];
echo '<h1>Stroop Test</h1><table class="stroop">';
for ($i = 1; $i <= 5; $i++) {
    echo '<tr>';
    for ($k = 1; $k <= 5; $k++) {
        $color = $colors[rand(0,9)];
        echo '<td>'.$color.'|'.getWord($colors, $color).'</td>';
    }
    echo '</tr>';
}
echo '</table>';
function getWord($colors, $color)
{
    $word =  $colors[rand(0,9)];
    if ($word == $color) {
        return getWord($colors, $color);
    } else {
        return $word;
    }
}
