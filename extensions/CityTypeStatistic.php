<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');

class CityTypeStatistic extends BaseAccountStatistic {

    public $startDate;
    public $endDate;

    public $cityTypesResults = [];

    /** @return mixed|void */
    public function getInitialData() : array {
        return $this->dataProvider->getAccountStatistic($this->startDate, $this->getMonthCountFromPeriodReport());
    }

    public function calculateMetrics(array $data) : void {
        foreach ($data as $type => $cityTypeResult) {
            $this->cityTypesResults[$type] = $cityTypeResult;
        }
    }


    public function getResultModelValuesArray() : array {
        return $this->cityTypesResults;
    }

}