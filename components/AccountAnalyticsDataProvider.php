<?php

Yii::import('app.modules.accountStatistics.components.ServiceCategoryInfoTrait');
Yii::import('app.models.root.AccountWorkStatisticPeer');

class AccountAnalyticsDataProvider {

    use ServiceCategoryInfoTrait;

    /**
     * Получение кол-ва визитов по всем сотрудникам организации за отчетный период
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return mixed
     */
    public function getEmployeeVisitCounts(DateTime $startDate, DateTime $endDate) {
        return [];
    }

    /**
     * Получение зарплат сотрудников организации за отчетный период
     * @param $employeeID
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function getEmployeeSalaries(DateTime $startDate, DateTime $endDate) {
        return [];
    }

    /**
     * Количество неудаленных сотрудников
     * @return int
     */
    public function getActiveEmployeeCount() {
        return EmployeeQuery::create()
            ->filterByVisible(1)
            ->count();
    }

    /**
     * Сумма Расходов средств организации
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function getCostAmountSum(DateTime $startDate, DateTime $endDate) {
        return [];
    }

    /**
     * Выручка по всем проданным товарам/услугам/сертификатам/абонементам
     * не удаленных(и не отмененных) визитов, которые оплачены
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return mixed
     */
    public function getRevenueSum(DateTime $startDate, DateTime $endDate) {
        return [];
    }

    /**
     * Коллекция родительских категорий
     * @return array|mixed|PropelObjectCollection
     */
    public function getActiveParentCategories() {
        return CategoryQuery::create()
            ->filterByVisible(1)
            ->filterByParentid(null)
            ->find();
    }

    /**
     * Коллекция дочерних категорий по родительской
     * @param $categories
     * @return array|false|mixed|PropelObjectCollection
     * @throws PropelException
     */
    public function getActiveChildCategories($categories) {
        if (!$categories) {
            return false;
        }
        return CategoryQuery::create()
            ->filterByVisible(1)
            ->filterByParent($categories)
            ->find();
    }

    /**
     * Высчитываются типы категорий, по категориям высчитываются cуммарные метрики
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return array
     * @throws Exception
     */
    public function getServiceMetrics(DateTime $startDate, DateTime $endDate) {
        return [];
    }

    /**
     * Получить стоимость оказания услуг по категории и их количество
     * @param array $categoryIDsArray
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return mixed
     */
    public function getServiceMetricsByCategoryIDs(array $categoryIDsArray, DateTime $startDate, DateTime $endDate) {
        return [];
    }


    /**
     * Возвращает массив ключей (тип категории в виде строки)
     * и соотвутствующих массивов (идентификаторов соответствующих категорий)
     * @return array
     * @throws Exception
     */
    public function getServiceCategoryTypesArray() {
        return [];
    }

    /**
     * Клиенты по категориям
     * @return mixed
     */
    public function getActualClientInfo() {
        return [];
    }


    /**
     * Cредние значения по статистике работы организаций сгруппированные по типу города
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param int $periodMonthQty
     * @return mixed
     * @throws PropelException
     */
    public function getAccountStatistic(DateTime $startDate, int $periodMonthQty) {
        return [];
    }

}