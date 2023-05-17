<?php

function sanitation($text, $dataType) {

    $text = trim($text);

    $text = strip_tags($text);

    $text = htmlspecialchars($text, ENT_QUOTES, "UTF-8");

    if ($dataType!="string") {
        if ($dataType=="email") {
            $text = filter_var($text, FILTER_SANITIZE_EMAIL);
        } else if ($dataType=="number_float") {
            $text = filter_var($text, FILTER_SANITIZE_NUMBER_FLOAT);
        } else if ($dataType=="number_int") {
            $text = filter_var($text, FILTER_SANITIZE_NUMBER_INT);
        } else if ($dataType=="url") {
            $text = filter_var($text, FILTER_SANITIZE_URL);
        }
    }

    return $text;
}

?>