<?php
namespace App\Tests;
use App\Tests\ApiTester;
class HealthCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function saneAndAlertTest(ApiTester $I)
    {
        $I->sendGet('/health');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"success":1}');
    }
}
