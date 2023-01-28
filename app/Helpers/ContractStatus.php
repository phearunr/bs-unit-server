<?php
namespace App\Helpers;
 
abstract class ContractStatus {
    const __default = self::OPEN;

    const CONTRACT = "CONTRACT";
    const OPEN = "OPEN";
    const CANCELLED = "CANCELLED";
    const VOIDED = "VOIDED";
    const RELEASED = "RELEASE";    


    public static function getStatuses()
    {
    	return [
    		self::OPEN,
    		self::CANCELLED,
            self::VOIDED,
    		self::RELEASED
    	];
    }
}