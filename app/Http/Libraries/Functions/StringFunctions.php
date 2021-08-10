<?php

namespace App\Http\Libraries\Functions;

trait StringFunctions {

    protected function createExcerpt($text, $word_count){
        $explodeText = explode(" ", $text);
        $wordsArray = array_slice($explodeText, 0, $word_count);
        return implode(' ', $wordsArray);
    }

    protected function createDelimitedString($string, $delimiter, $glue){
        $explode = explode($delimiter, $string);
        return implode($glue, $explode);
    }

    
}