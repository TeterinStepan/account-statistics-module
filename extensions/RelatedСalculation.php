<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');


// калькулятор значенйи которые необходимо посчитать после получения остальных данных
class RelatedСalculation extends BaseAccountStatistic {

    private $clientsStatistic;
    private $emploeyeeStatistic;
    private $financeStatistic;
    private $servicesStatistic;
    
    // публичное свойстов класса к которому мы при необходимости можем получить значение если захотим
    public $key = 0;


    public function __construct(
            BaseAccountStatistic $clients,
            BaseAccountStatistic $employee,
            BaseAccountStatistic $finance,
            BaseAccountStatistic $services,
            DateTime $startDate,
            DateTime $endDate
    ) {
        $this->clientsStatistic = $clients;
        $this->emploeyeeStatistic = $employee;
        $this->financeStatistic = $finance;
        $this->servicesStatistic = $services;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function calculateMetrics(array $data) : void {
        // здесь описываем логику расчета значений полученных из dataProvider 
        // расчетные значения записываем в свойства обьекта
        $this->key = (bool) $data['key'];
    }


    public function getResultModelValuesArray() : array {
        return [
            'key' => $this->key,
        ];
    }

}