<?php

include_once 'simple_html_dom.php';

$html = file_get_html('https://terrikon.com/football/italy/championship/archive');

if (isset($_POST["club"]) && !empty($_POST["club"])) {
    $club = $_POST["club"];
    $years = [];

    foreach($html->find('.maincol div.news a') as $element) {
        $res = str_replace(['/football/italy/championship/', '/table', 'table'], '', $element->href);
        if (!empty($res)) {
            $years[] = $res;
        }
    }


    echo '<h3>'.$club.'</h3>';
    foreach ($years as $year) {
        $html2 = file_get_html('https://terrikon.com/football/italy/championship/'.$year.'/table');
            foreach ($html2->find('table.colored', 0)->find('tr td a[href^=/football/teams/]') as $element) {
                if ($element->innertext == $club) {
                    $place = $element->parent()->prev_sibling();
                    $clubNum = str_replace('/football/teams/', '', $element->href);
                    echo 'Сезон '.$year. ' место '.$place.'<br>';
            }
        }
    }
}
