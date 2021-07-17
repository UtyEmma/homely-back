<?php

namespace App\Http\Libraries\Functions;

trait StringFunctions {

    public function createExcerpt($text, $word_count){
        $explodeText = explode(" ", $text);
        $wordsArray = array_slice($explodeText, 0, $word_count);
        return implode(' ', $wordsArray);
    }

    public function createDelimitedString($string, $delimiter, $glue){
        $explode = explode($delimiter, $string);
        return implode($glue, $explode);
    }

    
}