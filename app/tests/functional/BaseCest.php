<?php

namespace app\tests\functional;

use app\models\Cultures;
use app\models\Exporters;
use app\models\ExportersSuppliers;
use app\models\ParkingTimeWarnings;
use app\models\Stevedores;
use app\models\StevedoreUnloads;
use app\models\Suppliers;
use app\tests\fixtures\general\CulturesFixture;
use app\tests\fixtures\general\ExportersFixture;
use app\tests\fixtures\general\ExportersSuppliersFixture;
use app\tests\fixtures\general\StevedoresFixture;
use app\tests\fixtures\general\StevedoreUnloadsFixture;
use app\tests\fixtures\general\SuppliersFixture;
use app\forms\QuotasCreateForm;
use app\forms\TimeslotRequestCreateForm;
use app\forms\TimeslotRequestsHandleForm;
use app\forms\TimeslotSubmitForm;
use app\models\Quotas;
use app\models\TimeslotMovementLogs;
use app\models\TimeslotRequests;
use app\models\Timeslots;
use app\search\TimeslotRequestsSearch;
use app\search\TimeslotsSearch;
use app\tests\fixtures\general\UsersFixture;
use Brezgalov\TablesLogs\TablesLogFields;
use Brezgalov\TablesLogs\TablesLogs;
use yii\helpers\ArrayHelper;

class BaseCest
{
    /**
     * @return string[] массив имен классов фикстур
     */
    protected function getFixtures()
    {
        return [
            UsersFixture::class,
            CulturesFixture::class,
            ExportersFixture::class,
            SuppliersFixture::class,
            ExportersSuppliersFixture::class,
            StevedoresFixture::class,
            StevedoreUnloadsFixture::class,
        ];
    }

    /**
     * @param \FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        TablesLogFields::deleteAll();
        TablesLogs::deleteAll();

        TimeslotMovementLogs::deleteAll();
        TimeslotRequests::deleteAll();
        Timeslots::deleteAll();
        Quotas::deleteAll();

        ParkingTimeWarnings::deleteAll();
        Cultures::deleteAll();
        ExportersSuppliers::deleteAll();
        Exporters::deleteAll();
        Suppliers::deleteAll();
        StevedoreUnloads::deleteAll();
        Stevedores::deleteAll();

        $fixtures = $this->getFixtures();
        if (!empty($fixtures)) {
            $I->haveFixtures($fixtures);
        }
    }

    /**
     * @param \FunctionalTester $I
     */
    protected function handleRequests(\FunctionalTester $I)
    {
        $requestsFetcher = new TimeslotRequestsSearch(['without_timeslot' => true]);
        $requests = $requestsFetcher->getQuery()->orderBy('created_at ASC')->all();

        foreach ($requests as $request) {
            $handler = new TimeslotRequestsHandleForm(['request' => $request]);

            $I->assertTrue(!!$handler->handle(false), implode('; ', $handler->getErrorSummary(1)));
        }
    }

    /**
     * @param \FunctionalTester $I
     * @param array $data
     */
    protected function createQuotas(\FunctionalTester $I, array $data)
    {
        foreach ($data as $input) {
            $creatorForm = new QuotasCreateForm();
            $creatorForm->load($input, '');

            $quota = $creatorForm->createQuotas();

            $I->assertFalse(
                $creatorForm->hasErrors(),
                implode('; ', $creatorForm->getErrorSummary(1))
            );

            $I->assertNotEmpty(
                $quota,
                'Квота пустая'
            );
        }
    }

    /**
     * @param \FunctionalTester $I
     * @param array $data
     */
    protected function createRequests(\FunctionalTester $I, array $data)
    {
        foreach ($data as $input) {
            $creatorForm = new TimeslotRequestCreateForm($input);

            $result = $creatorForm->createRequest();

            $I->assertTrue(
                !!$result,
                implode('; ', $creatorForm->getErrorSummary(1))
            );
        }
    }

    /**
     * @param \FunctionalTester $I
     * @param $count
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function checkRequestsStillActive(\FunctionalTester $I, $count)
    {
        $requestsFetcher = new TimeslotRequestsSearch(['without_timeslot' => true]);
        $requests = $requestsFetcher->getQuery()->orderBy('created_at ASC')->all();

        $I->assertCount($count, $requests);

        return $requests;
    }

    /**
     * Формат
     * [
     *     'a111a11' => [
     *         ?'assertCount' => 1,
     *         *'status' => 'status here'
     *     ]
     * ]
     * @param \FunctionalTester $I
     * @param array $setup
     */
    protected function checkRequestStatuses(\FunctionalTester $I, array $setup)
    {
        foreach ($setup as $plate => $input) {
            /* @var TimeslotRequests[] $requestSuccess */
            $requestSuccess = TimeslotRequests::find()
                ->where(['plate_truck' => $plate])
                ->orderBy('id DESC')
                ->all();

            if (!array_key_exists('assertCount', $setup)) {
                 $setup['assertCount'] = 1;
            }

            $I->assertCount($setup['assertCount'], $requestSuccess);

            if (array_key_exists('status', $setup) && $setup['status']) {
                $I->assertEquals($setup['status'], $requestSuccess[0]->state_system);
            }
        }
    }

    /**
     * Проверка количества таймслотов в системе в целом
     * @param \FunctionalTester $I
     * @param $plate
     * @param int $count
     */
    protected function checkTimeslotExists(\FunctionalTester $I, $setup = [])
    {
        $count = ArrayHelper::getValue($setup, 'count', 1);

        $search = new TimeslotsSearch();
        $search->load($setup, '');

        $I->assertEquals($count, $search->getQuery()->count());
    }

    /**
     * @param \FunctionalTester $I
     * @param $plate
     */
    protected function submitTimeslot(\FunctionalTester $I, $plate)
    {
        /////// Подтверждаем первый таймслот

        $timeslot = Timeslots::findOne(['plate_truck' => $plate]);
        $I->assertNotEmpty($timeslot);
        $I->assertEquals(Timeslots::SUBMIT_STATUS_NOT_STATED, $timeslot->submit_status);

        $submitForm = new TimeslotSubmitForm([
            'timeslot_id'       => $timeslot->id,
            'submit'            => 1,
            'useTransaction'    => false,
        ]);

        $I->assertTrue(!!$submitForm->getResult());

        $timeslot = Timeslots::findOne($timeslot->id);

        $I->assertEmpty($timeslot->expire_at);
        $I->assertEmpty($timeslot->deleted_at);
        $I->assertEquals(Timeslots::SUBMIT_STATUS_SUBMITTED, $timeslot->submit_status);
    }
}