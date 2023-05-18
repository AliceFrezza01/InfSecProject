<?php

function sanitation($text, $dataType, $quoteStrict) {
/*
    $text = trim($text);

    $text = strip_tags($text);

    if ($quoteStrict)
        $text = htmlspecialchars($text, ENT_QUOTES, "UTF-8");
    else 
        $text = htmlspecialchars($text, ENT_NOQUOTES, "UTF-8");

    if ($dataType=="email") {
        $validate = filter_var($text, FILTER_VALIDATE_EMAIL);
    } else if ($dataType=="number_float") {
        $validate = filter_var($text, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
    } else if ($dataType=="number_int") {
        $validate = filter_var($text, FILTER_VALIDATE_INT);
    } else if ($dataType=="url") {
        $validate = filter_var($text, FILTER_VALIDATE_URL);
    } else {
        $validate = true;
    }

    if ($validate) {
        return $text;
    } else {
        return "";
    } */

    return $text;
}

?>