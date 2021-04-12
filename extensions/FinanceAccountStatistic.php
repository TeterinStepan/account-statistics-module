<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');

class FinanceAccountStatistic extends BaseAccountStatistic {

    protected const COST_TYPE = 'cost';
    protected const REVENUE_TYPE = 'revenue';

    // публичное свойстов класса к которому мы при необходимости можем получить значение если захотим
    public $key = 0;


    /**
     * @return array
     */
    public function getInitialData(): array {
        return [
            $this->dataProvider->getCostAmountSum($this->startDate, $this->endDate),
            $this->dataProvider->getRevenueSum($this->startDate, $this->endDate)
        ];
    }

    /**
     * @param array $data
     * @return $this|void
     */
    public function calculateMetrics(array $data): void {
        // здесь описываем логику расчета значений полученных из dataProvider 
        // расчетные значения записываем в свойства обьекта
        $this->key = (bool) $data['key'];
    }

    /**
     * Необходимые значения для записи в БД
     * @return array массив итоговых значений которые уже на данном этапе могут быть записаны в БД
     */
    public function getResultModelValuesArray(): array {
        return [
            'key' => $this->key,
        ];
    }

}