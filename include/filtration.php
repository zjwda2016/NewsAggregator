<?php
/*Function  the left means to exclude the left side of the specified string, right means to exclude  to the right of the specified string */
function excludeString($replacedString, $originalString, $a){
    if(!$replacedString){
        return "The replaced string does not exist";
    }
    $replacedString = mb_convert_encoding($replacedString, 'GB2312', 'UTF-8');
    $originalString = mb_convert_encoding($originalString, 'GB2312', 'UTF-8');
    if($a == ""){
    $last = str_replace($replacedString, "", $originalString);
    }elseif($a == "right"){
        $last = preg_replace("/[" . $replacedString . "]+[\d\D\w\W\s\S]*/", "", $originalString);

        }elseif($a == "left"){
            $last = preg_replace("/[\d\D\w\W\s\S]*[". $replacedString . "]+/", "", $originalString);
            }
            $last =  mb_convert_encoding($last, 'UTF-8', 'GB2312'); 
    return $last;

    }
?>