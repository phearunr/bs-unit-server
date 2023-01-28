<?php
namespace App\Helpers;
 
class DigitGenerator {

    /**
     * Generator a string with leght of digit 
     * which contain number from 0 to 9
     * @param  Int digit
     * @return string
     * @throws \InvalidArgumentException
     */
    static function create(int $digit)
    {
        if ( !is_int($digit) ) {
            throw new \InvalidArgumentException("Argument must be positive integer.");
        }

        if ( $digit < 0 ) {
            throw new \InvalidArgumentException("Argument can not be negative integer. Given value is : ".$digit);
        }

        $result = "";
        for ( $i = 0; $i < $digit; $i++ ) {
            $result.= mt_rand(0,9);
        }
        return $result;
    }
}