<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');

class ClientAccountStatistic extends BaseAccountStatistic {

    // публичное свойстов класса к которому мы при необходимости можем получить значение если захотим
    public $key = 0;

    /**
     * @return mixed|void
     */
    public function getInitialData() : array {
        return $this->dataProvider->getActualClientInfo($this->startDate, $this->endDate);
    }

    /**
     * @param array $data
     * @return ClientAccountStatistic|void
     */
    public function calculateMetrics(array $data) : void {
        // здесь описываем логику расчета значений полученных из dataProvider 
        // расчетные значения записываем в свойства обьекта
        $this->key = (bool) $data['key'];
    }

    /**
     * Необходимые значения для записи в БД
     * @return array массив итоговых значений которые уже на данном этапе могут быть записаны в БД
     */
    public function getResultModelValuesArray () : array {
        return [
            'key' => $this->key,
        ];
    }
}