<?php
namespace App\Helpers;
 
class UserRole {
    const __default = self::AGENT;
    
    const ADMINISTRATOR = "administrator";
    const SALE_MANAGER = "sale_manager";
    const UNIT_CONTROLLER = "unit_controller";
    const SALE_TEAM_LEADER = "sale_team_leader";
    const AGENT = "agent";
    const CONTRACT_CONTROLLER = "contract_controller";
    const ACCOUNTANT = "accountant";
    const REPORT = 'report';
    const SITE_MANAGER = 'site_manager';
    const SITE_ENGINEER = 'site_engineer';
    const CUSTOMER_SERVICE = 'customer_service';
    const PROJECT_COORDINATOR = 'project_coordinator';
    const USER = 'user';
    const HANDOVER_OFFICER = 'handover_officer';

    public static function toArray() {
        return [
            self::ADMINISTRATOR,
            self::SALE_MANAGER,
            self::UNIT_CONTROLLER,
            self::SALE_TEAM_LEADER,
            self::AGENT,
            self::CONTRACT_CONTROLLER,
            self::ACCOUNTANT,
            self::REPORT,
            self::SITE_MANAGER,
            self::SITE_ENGINEER,
            self::CUSTOMER_SERVICE,
            self::PROJECT_COORDINATOR,
            self::USER,
            self::HANDOVER_OFFICER,
        ];
    }
}