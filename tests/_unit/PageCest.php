<?php

use devskyfly\yiiExtensionSitemap\Page;

class PageCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $page = new Page();
    }
}
