<?php

Yii::import('app.modules.accountStatistics.components.*');

class AccountStatisticsModule extends CWebModule {

    /**
     * Сервис расчета статистики по деятельности организации
     * Отвечает за расчет и предоставление статистики
     * @var AccountAnalyticsService $accountAnalyticsService
     */
    private $accountAnalyticsService;

    /**
     * Сервис расчета итоговых результатов по типу городов
     * Отвечает за расчет и предоставление статистики
     * @var CityTypeAnalyticsService $cityTypeAnalyticsService
     */
    private $cityTypeAnalyticsService;

    /**
     * Обеспечивает сервисы необходимыми данными
     * @var AccountAnalyticsDataProvider $accountAnalyticsDataProvider
     */
    private $accountAnalyticsDataProvider;

    /** @return AccountAnalyticsService */
    public function getAccountAnalyticsService() : AccountAnalyticsService {
        if($this->accountAnalyticsService) {
            return $this->accountAnalyticsService;
        }
        $this->accountAnalyticsService = new AccountAnalyticsService();
        return $this->accountAnalyticsService;
    }

    /** @return CityTypeAnalyticsService */
    public function getCityTypeAnalyticsService() : CityTypeAnalyticsService {
        if($this->accountAnalyticsService) {
            return $this->cityTypeAnalyticsService;
        }
        $this->cityTypeAnalyticsService = new CityTypeAnalyticsService();
        return $this->cityTypeAnalyticsService;
    }

    /** @return AccountAnalyticsDataProvider */
    public function getAccountAnalyticsDataProvider() : AccountAnalyticsDataProvider {
        if($this->accountAnalyticsDataProvider) {
            return $this->accountAnalyticsDataProvider;
        }
        $this->accountAnalyticsDataProvider = new AccountAnalyticsDataProvider();
        return $this->accountAnalyticsDataProvider;
    }
}
