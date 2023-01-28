<?php
namespace App\Helpers;
 
class GenderHelper {

	 /**
     * Convert Gender integer to String 
     * [ 1 => "Male" , 2 => "Female", other => "N/A"]
     *
     * @return String 
     */
    public static function getGenderText($gender_integer) {
    	switch ($gender_integer) {
    		case 1:
    			return "Male";
    			break;

    		case 2:
    			return "Female";
    			break;
    		
    		default:
    			return "N/A";
    			break;
    	}
    }
}