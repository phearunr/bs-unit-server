<?php
namespace App\Helpers;
 
class KhmerMonth {

    static function convertToKhmerMonth(int $month)
    {
    	switch ($month) {
    		case 1:
    			return "មករា";
    		case 2:
    			return "កុម្ភះ";
    		case 3:
    			return "មិនា";
    		case 4:
    			return "មេសា";
    		case 5:
    			return "ឧសភា";
    		case 6:
    			return "មិថុនា";
    		case 7:
    			return "កក្កដា";
    		case 8:
    			return "សីហា";
    		case 9:
    			return "កញ្ញា";
    		case 10:
    			return "តុលា";
    		case 11:
    			return "វិច្ឆិកា";
    		case 12:
    			return "ធ្នូ";
    		default:
    			return "N/A";    			
    	}	
    }
}