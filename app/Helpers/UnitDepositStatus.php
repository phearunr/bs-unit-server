<?php
namespace App\Helpers;
 
abstract class UnitDepositStatus {
    const __default = self::DEPOSIT;
    
    const DEPOSIT = "DEPOSIT";
    const PENDING = "PENDING";
    const APPROVED = "APPROVED";
    const REJECTED = "REJECTED";
    const CANCELLED = "CANCELLED";
    const CHANGED = "CHANGED";
    const RELEASE = "RELEASE";
    const OVERDUE = "OVERDUE";
    const VOIDED = "VOIDED";

    public static function getDepositStatuses()
    {
    	return [
		    self::PENDING,
		    self::APPROVED,
		    self::REJECTED,
		    self::CANCELLED,
		    self::CHANGED,
		    self::RELEASE,
		    self::OVERDUE,
            self::VOIDED
    	];
    }

    public static function toArray() {
        return [
            self::PENDING,
            self::APPROVED,
            self::REJECTED,
            self::CANCELLED,
            self::CHANGED,
            self::RELEASE,
            self::OVERDUE,
            self::VOIDED
        ];
    }
}