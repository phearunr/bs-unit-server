<?php
namespace App\Helpers;
 
abstract class UnitStatus {
    const __default = self::AVAILABLE;
    
    const AVAILABLE = "AVAILABLE";
    const UNAVAILABLE = "UNAVAILABLE";
    const HOLD = "HOLD";
    const DEPOSIT = "DEPOSIT";
    const CONTRACT = "CONTRACT";
    const HANDOVERED = "HANDOVERED";

    public static function getUnitStatuses()
    {
    	return [
    		self::AVAILABLE,
    		self::UNAVAILABLE,
    		self::HOLD,
    		self::DEPOSIT,
    		self::CONTRACT,
            self::HANDOVERED,
    	];
    }
}