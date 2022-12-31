<?php
namespace App\Tests;
use App\Tests\ApiTester;
class WordCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function getWordListTest(ApiTester $I)
    {
        // $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/words/abcde');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }
}
