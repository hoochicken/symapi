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
        // $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/health');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"result":"ok"}');
    }
}
