<?php

Yii::import('app.modules.accountStatistics.components.AccountAnalyticsDataProvider');

class BaseAccountStatistic {
    protected $startDate;
    protected $endDate;
    protected $dataProvider;

    /**
     * BaseAccountStatistic constructor.
     * @param AccountAnalyticsDataProvider $dataProvider
     * @param DateTime $startDate
     * @param DateTime $endDate
     */
    public function __construct(AccountAnalyticsDataProvider $dataProvider, DateTime $startDate, DateTime $endDate) {
        $this->dataProvider = $dataProvider;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return $this
     */
    public function calculate(){
        $this->calculateMetrics($this->getInitialData());
        return $this;
    }


    public function getInitialData() : array {
        return [];
        // метод должен получать данные из dataProvide и возвращать их для разбора в calculateMetrics
    }

    /**
     * @param array $data
     * @return $this
     */
    public function calculateMetrics(array $data) : void {
        // обработка результатов полученных из dataProvide
    }

    /**
     * Необходимые значения для записи в БД
     * @return array массив итоговых значений которые уже на данном этапе могут быть записаны в БД
     */
    public function getResultModelValuesArray() : array {
        return [];
    }

    /**
     * Количество недель в отчетном периоде
     * @return int
     */
    protected function getWeekCountFromPeriodReport() : int {
        $diff = $this->endDate->diff($this->startDate);
        return intdiv ( $diff->days, 7 );
    }

    /**
     * Количество месяцев в отчетном периоде
     * @return int
     */
    protected function getMonthCountFromPeriodReport() : int  {
        $diff = $this->endDate->diff($this->startDate);
        return $diff->m;
    }
}