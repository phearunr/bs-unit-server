<?php
namespace App\Helpers;
 
abstract class UnitContractStatus {
    const __default = self::CONTRACT;
    
    const CONTRACT = "CONTRACT";
    const PENDING = "PENDING";
    const APPROVED = "APPROVED";
    const REJECTED = "REJECTED";
    const CANCELLED = "CANCELLED";
    const OVERDUE = "OVERDUE";   
    const RELEASED = "RELEASE";
    const OPEN = "OPEN";
    const VOIDED = "VOIDED";

    public static function toArray() {
        return [
            self::PENDING,
            self::APPROVED,
            self::REJECTED,
            self::CANCELLED,
            self::OVERDUE,
            self::RELEASED,
            self::OPEN,
            self::VOIDED
        ];
    }
}