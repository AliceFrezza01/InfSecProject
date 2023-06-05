<?php

/**
 * Takes as input a possible unsafe data and returns as output a sanitized and encoded data,
 * which is resistant in case of XSS attacks. In cases in which the input string does not comply
 * at all with the type it should be, then an empty string is returned. 
 *
 * 
 * @param $text             String the input value which needs to be sanitized.
 * @param $dataType         String the possible values are "string", "email", "number_float",
 *                          "number_int" and "url". If other value types are inserted, then they are
 *                          automatically treated as "string".
 * @param $quoteStrict      Boolean TRUE if we don't want to allow double quotes to be encoded (by default). FALSE otherwise.
 * @return                  String sanitized and encoded data OR empty String
 * @throws                  Exception If element in array is not an integer
 */
function sanitation($text, $dataType, $quoteStrict = true) {

    //trim — Strip whitespace (or other characters) from the beginning and end of a string
    $text = trim($text);

    //strip_tags — Strip HTML and PHP tags from a string
    $text = strip_tags($text);

    //htmlspecialchars() — Convert special characters to HTML entities
    if ($quoteStrict)
        $text = htmlspecialchars($text, ENT_QUOTES, "UTF-8");
    else 
        $text = htmlspecialchars($text, ENT_NOQUOTES, "UTF-8");

    //filter_var — Filters a variable with a specified filter. In this function I use the validate filters.
    //They return true if the data is of the type it should be. 
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
    }
}