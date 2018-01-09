<?php

use Guj\DataPush\Exception\GujDataPushException;
use Guj\DataPush\Model\DataPushModel;

class DataPushModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testToJson()
    {
        $datapushModel = new DataPushModel();
        $this->assertEquals('[]', $datapushModel->toJSON());
    }

    public function testConvertToDate()
    {
        $this->tester->wantToTest('convertToDate Method to ensure correct behavior');
        $dataPushModel = new DataPushModel();

        // assertions
        $exspectedException = new GujDataPushException("Unable to convert datestring/timestamp", GujDataPushException::VALIDATION_EXCEPTION_CODE);
        $this->tester->expectException(
            $exspectedException,
            function () use ($dataPushModel) {
                $dataPushModel->convertToDate('FOOO');
            }
        );

        $this->tester->expectException(
            $exspectedException,
            function () use ($dataPushModel) {
                $dataPushModel->convertToDate('FOOO', false);
            }
        );

        $convertedDate = $dataPushModel->convertToDate('01.01.2017');
        $this->assertEquals('2017-01-01T00:00:00Z', $convertedDate);
        $convertedDate = $dataPushModel->convertToDate('01.01.2017', false);
        $this->assertEquals('01.01.2017', $convertedDate);
        $convertedDate = $dataPushModel->convertToDate('01.01.2017 10:55:55');
        $this->assertEquals('2017-01-01T10:55:55Z', $convertedDate);
        $convertedDate = $dataPushModel->convertToDate('01.01.2017 10:55:55', false);
        $this->assertEquals('01.01.2017', $convertedDate);
        $convertedDate = $dataPushModel->convertToDate(mktime(0, 0, 1, 1, 1, 2017));
        $this->assertEquals('2017-01-01T00:00:01Z', $convertedDate);
        $convertedDate = $dataPushModel->convertToDate(mktime(0, 0, 1, 1, 1, 2017), false);
        $this->assertEquals('01.01.2017', $convertedDate);
    }
}