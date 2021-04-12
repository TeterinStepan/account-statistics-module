<?php

trait ServiceCategoryInfoTrait {

    /**
     * @param Category $category
     * @return string
     */
    public function calculateCategoryType(Category $category) {
        $categoryName = $category->getName();

        if ($this->isNailCategory($categoryName)) {
            return AccountWorkStatisticPeer::NAIL_CATEGORY_TYPE;
        } else if ($this->isHairdressingCategory($categoryName)) {
            return AccountWorkStatisticPeer::HAIRDRESSING_CATEGORY_TYPE;
        } else if ($this->isEyebrowsAndEyelashesCategory($categoryName)) {
            return AccountWorkStatisticPeer::EYEBROWNS_AND_EYELASHES_CATEGORY_TYPE;
        } else if ($this->isCosmetologyCategory($categoryName)) {
            return AccountWorkStatisticPeer::COSMETOLOGY_CATEGORY_TYPE;
        } else if ($this->isBodyCareCategory($categoryName)) {
            return AccountWorkStatisticPeer::BODYCARE_CATEGORY_TYPE;
        } else if ($this->isDepilationCategory($categoryName)) {
            return AccountWorkStatisticPeer::DEPILATION_CATEGORY_TYPE;
        }
        return AccountWorkStatisticPeer::OTHER_CATEGORY_TYPE;
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isNailCategory(string $categoryName) {
        return (bool)preg_match(
            '/([м,М]аникюр)|([п,П]едикюр)/',
            $categoryName
        );
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isHairdressingCategory(string $categoryName) {
        return (bool)preg_match(
            '/([п,П]арик)|([с,C]трижк)/',
            $categoryName
        );
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isEyebrowsAndEyelashesCategory(string $categoryName) {
        return (bool)preg_match('/([б,Б]ров)/', $categoryName);
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isCosmetologyCategory(string $categoryName) {
        return (bool)preg_match('/([к,К]осмет)/', $categoryName);
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isBodyCareCategory(string $categoryName) {
        return (bool)preg_match('/([м,М]ассаж)/', $categoryName);
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isDepilationCategory(string $categoryName) {
        return (bool)preg_match('/([б,Б]икин)/', $categoryName);
    }

    /**
     * @param string $categoryName
     * @return bool
     */
    protected function isOtherCategory(string $categoryName) {
        return (bool)preg_match('', $categoryName);
    }

    /**
     * @param $categoryTypesArray
     * @param $categories
     */
    protected function modifyCategoryTypesArray(&$categoryTypesArray, $categories) {
        /** @var Category $category */
        foreach ($categories as $category) {
            $categoryType = $this->getCategoryType($categoryTypesArray, $category);
            $this->addCategoryTypeInArray($categoryTypesArray, $categoryType, $category->getId());
        }
    }

    /**
     * @param $categoryTypesArray
     * @param $category
     * @return int|string
     */
    protected function getCategoryType(&$categoryTypesArray, $category) {
        $categoryType = null;
        if ($category->getParentid()) {
            // если у родительской категории уже есть тип, то выставляем текущей категории соответвующий тип
            $categoryType = $this->getTypeByParentCategory($categoryTypesArray, $category->getParentid());
        }
        // иначе высчитываем тип категории
        if (!$categoryType) {
            return $this->calculateCategoryType($category);
        }
        return $categoryType;
    }

    /**
     * @param $categoryTypesArray
     * @param $categoryType
     * @param $categoryID
     */
    protected function addCategoryTypeInArray(&$categoryTypesArray, $categoryType, $categoryID) {
        if (!$categoryTypesArray[$categoryType]) {
            $categoryTypesArray[$categoryType] = [];
        }
        $categoryTypesArray[$categoryType][] = $categoryID;
    }

    /**
     * @param $categoryTypesArray
     * @param $parentCategoryID
     * @return int|string
     */
    protected function getTypeByParentCategory(&$categoryTypesArray, $parentCategoryID) {
        foreach ($categoryTypesArray as $categoryType => $categoriesArray) {
            foreach ($categoriesArray as $categoryID) {
                if ($categoryID === $parentCategoryID) {
                    return $categoryType;
                }
            }
        }
        return '';
    }

}