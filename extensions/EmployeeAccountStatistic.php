<?php

Yii::import('app.modules.accountStatistics.extensions.BaseAccountStatistic');


class EmployeeAccountStatistic extends BaseAccountStatistic {

    protected const VISIT_TYPE = 'visit';
    protected const SALARIES_TYPE = 'salary';
    protected const EMPLOYEE_COUNT = 'employee_count';

     // публичное свойстов класса к которому мы при необходимости можем получить значение если захотим
    public $key = 0;

    public function getInitialData(): array {
        return [
            self::VISIT_TYPE => $this->dataProvider->getEmployeeVisitCounts($this->startDate, $this->endDate),
            self::SALARIES_TYPE => $this->dataProvider->getEmployeeSalaries($this->startDate, $this->endDate),
            self::EMPLOYEE_COUNT => $this->dataProvider->getActiveEmployeeCount()
        ];
    }

    /**
     * @param array $data
     * @return array
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