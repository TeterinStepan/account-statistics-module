<?php

Yii::import('app.modules.accountStatistics.components.*');
Yii::import('app.modules.accountStatistics.extensions.*');
Yii::import('app.models.root.AccountWorkStatisticPeer');

class CityTypeAnalyticsService {

    protected $resultModels = [];
    protected $reportInfos;
    protected $startDate;
    protected $endDate;
    protected $dataProvider;

    /**
     * CityTypeAnalytics constructor.
     */
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
        if (!$this->resultModels) {
            throw new Exception('Массив моделей данных не был инициализирован');
        }
        foreach ($this->resultModels as $model) {
            $model->save();
        }
    }

    /**
     * @return CityTypeStatistic array
     */
    public function getResultModel() {
        return $this->resultModels;
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
        $this->initDataProvider();
        $this->initReportDates();
        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getStatistic() {
        try {
            return (new CityTypeStatistic($this->dataProvider, $this->startDate, $this->endDate))
                ->calculate()
                ->getResultModelValuesArray();
        } catch (Exception $e) {
            $message = 'Ошибка получения статистики по организации ' .
                'Код: ' . $e->getCode() . '; ' .
                'Сообщение: ' . $e->getMessage();
            $this->logging($message);
            throw new Exception($message, 500);
        }
    }


    /**
     * @param array $data
     */
    protected function mapInfosToModel(array $data) {
        foreach ($data as $categoryStatistic => $results) {

            $this->resultModels = [];
            $this->resultModels[$categoryStatistic] = new CityTypeWorkStatistic();

            foreach ($results as $key => $value) {
                try {
                    $method = 'set' . ucfirst(strtolower($key));
                    $this->resultModels[$categoryStatistic]->$method($value);

                } catch (Exception $e) {
                    $this->logging(
                        'Ошибка наполнения модели данными '
                        . 'Код: ' . $e->getCode() . '; '
                        . 'Сообщение: ' . $e->getMessage()
                    );
                }
            }
        }
        return $this->resultModels;
    }

    public function setCityType(string $type) {
        $this->type = $type;
        return $this;
    }

    public function setCity(string $city) {
        $this->city = $city;
        return $this;
    }

    protected function initDataProvider() {
        $module = app()->getModule('accountStatistics');
        $this->dataProvider = $module->getAccountAnalyticsDataProvider();
    }

    protected function initReportDates() {
        $this->startDate = (new DateTime())->modify('first day of this month')->modify('- 6 month');
        $this->endDate = (new DateTime())->modify('first day of this month');
    }

    protected function logging(string $message) {
        var_dump($message);
    }

}