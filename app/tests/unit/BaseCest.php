<?php

namespace app\tests\unit;

abstract class BaseCest
{
    /**
     * @return string[] массив имен классов фикстур
     */
    protected function getFixtures()
    {
        return [
        ];
    }

    /**
     * @param \app\tests\UnitTester $I
     */
    public function _before(\app\tests\UnitTester $I)
    {
        $fixtures = $this->getFixtures();
        if (!empty($fixtures)) {
            $I->haveFixtures($fixtures);
        }
    }
}