# account-statistics-module
Модуль расчета статистики по организации (аккаунту)

## Зависимости
PHP 7.2
Yii 1.1
Propel

## Для запуска расчета статистики необходимо:
1. Добавить модуль в Yii
2. Создать модель данных Propel 
3. Реализовать логику получения данных в AccountAnalyticsDataProvider.php /modules/accountStatistics/components/AccountAnalyticsDataProvider.php 
4. Реализовать логику расчета нужных значений в CityTypeStatistic.php, ClientAccountStatistic.php, EmployeeAccountStatistic.php, FinanceAccountStatistic.php
5. Реализовать логику расчета значений RelatedСalculation.php, которые должны расчитываться на базе полученнных/расчетных CityTypeStatistic, ClientAccountStatistic...
6. При необходимости добавить логику логирования в AccountAnalyticsService->logging($message), например kibana / файл и тд

## Пример запуска расчета статистики для организации

`$module = app()->getModule('accountStatistics');
$service = $module->getAccountAnalyticsService();
$service->setOrganization(app()->getOrganization());
$service->run()->save();`

Сервис самостоятельно сохранит данных в базу при успешном выполнении



