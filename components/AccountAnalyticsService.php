<?php

Yii::import('app.modules.accountStatistics.components.*');
Yii::import('app.modules.accountStatistics.extensions.*');
Yii::import('app.models.root.AccountWorkStatisticPeer');

class AccountAnalyticsService {

    protected $org;
    protected $resultModel;
    protected $reportInfos;
    protected $startDate;
    protected $endDate;
    protected $dataProvider;

    /** AccountAnalyticsService constructor. */
    public function __construct() {
        return $this;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function run() {
        try {
            $this->init();
            $this->mapInfosToModel($this->getStatistic());
            return $this;
        } catch (Exception $e) {
            throw new Exception('Ошибка обработки организации: ' . $e->getMessage, $e->getCode());
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function save() {
        if (!$this->resultModel) {
            throw new Exception('Модель данных не была инициализирована');
        }
        return $this->resultModel->save();
    }

    /**
     * @return AccountWorkStatistic
     */
    public function getResultModel() {
        return $this->resultModel;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getStatisticArray() {
        return $this->getStatistic();
    }


    /**
     * @return $this
     * @throws Exception
     */
    protected function init() {
        $this->checkOrganization();
        $this->initDataProvider();
        $this->initReportDates();
        $this->initModel();
        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getStatistic() {
        try {
            $provider = $this->dataProvider;
            $start = $this->startDate;
            $end = $this->endDate;

            $clients = (new ClientAccountStatistic($provider, $start, $end))->calculate();
            $employees = (new EmployeeAccountStatistic($provider, $start, $end))->calculate();
            $finance = (new FinanceAccountStatistic($provider, $start, $end))->calculate();
            $services = (new ServiceAccountStatistic($provider, $start, $end))->calculate();
            $relatedСalculation = (new RelatedСalculation($clients, $employees, $finance, $services, $start, $end))->calculate();

            return [
                $clients->getResultModelValuesArray(),
                $employees->getResultModelValuesArray(),
                $finance->getResultModelValuesArray(),
                $services->getResultModelValuesArray(),
                $relatedСalculation->getResultModelValuesArray(),
            ];
        } catch (Exception $e) {
            $message = 'Ошибка получения статистики по организации ' .
                'Код: ' . $e->getCode() . '; ' .
                'Сообщение: ' . $e->getMessage();
            $this->logging($message);
            throw new Exception($message, 500);
        }
    }

    /**
     * Собираем модель в которую будем записывать данные 
     * @return $this
     * @throws PropelException
     */
    protected function initModel() {
        $oldResultModel = $this->getOldResultModel();

        if ($oldResultModel) {
            $this->resultModel = $oldResultModel;
        } else {
            $this->resultModel = (new AccountWorkStatistic())
                ->setOrganization($this->org)
                ->setCity($this->org->getCity())
                ->setCitytype($this->org->getCitytype());
        }
        return $this;
    }

    /**
     * @return AccountWorkStatistic
     * @throws PropelException
     */
    protected function getOldResultModel() {
        return AccountWorkStatisticQuery::create()
            ->filterByOrganization($this->org)
            ->filterByBeginningofperiod($this->startDate)
            ->filterByPeriodmonthqty(($this->endDate->diff($this->startDate))->m)
            ->findOne();
    }

    /**
     * @param array $data
     */
    protected function mapInfosToModel(array $data) {
        foreach ($data as $categoryStatistic => $results) {
            foreach ($results as $key => $value) {
                try {
                    $method = 'set' . ucfirst(strtolower($key));
                    $this->resultModel->$method($value);
                } catch (Exception $e) {
                    $this->logging(
                        'Ошибка наполнения модели данными '
                        . 'Код: ' . $e->getCode() . '; '
                        . 'Сообщение: ' . $e->getMessage()
                    );
                }
            }
        }
        return $this->resultModel;
    }

    public function setOrganization(Organization $org) {
        $this->org = $org;
        app()->setContextOrgID($org->getId()); 
        return $this;
    }

    protected function checkOrganization() {
        if (!$this->org) $this->org = app()->getOrganization();
        if (!$this->org) throw new Exception('Не задана организация для сбора данных');
    }

    protected function initDataProvider() {
        $module = app()->getModule('accountStatistics');
        $this->dataProvider = $module->getAccountAnalyticsDataProvider();
    }

    protected function initReportDates() {
        $this->startDate = (new DateTime())->modify('first day of this month')->modify('- 6 month');
        $this->endDate = (new DateTime())->modify('first day of this month');
    }

    /**
     * @param string $message
     * @throws Exception
     */
    protected function logging(string $message) {
        // при необходимости добавить лог в кибану или в файл
        throw new Exception($message, 500);
    }

}