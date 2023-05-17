<?php

function sanitation($textString, $maxLenght, $dataType) {

    if (!is_string($textString)) {
        return "";
    }

    if ($maxLenght!=null && strlen($textString)>$maxLenght) {
        return "";
    }

    $textString = trim($textString);
    $textString = strip_tags($textString);

    $textString = htmlspecialchars($textString);

    if ($dataType=="email") {
        $isValid = filter_var($textString, FILTER_VALIDATE_EMAIL) !== false;
        if(!$isValid)
            return "invalid input";
    }

    return $textString;
}

?>