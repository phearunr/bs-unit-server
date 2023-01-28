<?php
namespace App\Helpers;
 
abstract class UnitHoldStatus {
    const __default = self::HOLD;
    
    const HOLD = "HOLD";
    const PENDING = "PENDING";
    const APPROVED = "APPROVED";
    const REJECTED = "REJECTED";
    const CANCELLED = "CANCELLED";
    const OVERDUE = "OVERDUE";   
    const RELEASE = "RELEASE";

  	public static function toArray() {
  		return [
  			self::HOLD,
		    self::PENDING,
		    self::APPROVED,
		    self::REJECTED,
		    self::CANCELLED,
		    self::OVERDUE,
		    self::RELEASE 
  		];
  	}
}