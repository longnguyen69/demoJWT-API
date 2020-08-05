<?php
$I = new AcceptanceTester($scenario);
$I->amOnPage('/');
$I->click('login');
$I->see('login');

