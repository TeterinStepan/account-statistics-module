<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');
Yii::import('app.models.root.AccountWorkStatisticPeer');

class ServiceAccountStatistic extends BaseAccountStatistic {

    // публичное свойстов класса к которому мы при необходимости можем получить значение если захотим
    public $key = 0;


    /**
     * @return array|void
     * @throws Exception
     */
    public function getInitialData(): array {
        return $this->dataProvider->getServiceMetrics($this->startDate, $this->endDate);
    }

    /**
     * @param array $data
     * @return ServiceAccountStatistic|void
     * @throws Exception
     */
    public function calculateMetrics(array $data): void {
        // здесь описываем логику расчета значений полученных из dataProvider 
        // расчетные значения записываем в свойства обьекта
        $this->key = (bool) $data['key'];
    }

    /**
     * Необходимые значения для запиCи в БД
     * @return array маCCив итоговых значений которые уже на данном этапе могут быть запиCаны в БД
     */
    public function getResultModelValuesArray(): array {
        return [
            'key' => $this->key,
        ];
    }

}