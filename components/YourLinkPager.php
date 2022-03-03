<?php

namespace app\components;

use yii\helpers\Html;
use yii\widgets\LinkPager;

class YourLinkPager extends LinkPager
{
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $str = [
                'label' => $label,
                'href' => $this->pagination->createUrl($page),
                'active' => $active
        ];

        return $str;
    }


    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount(); // Клличество страниц
        if ($pageCount < 2 && $this->hideOnSinglePage) { // Количество страниц меньше двух
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // первая страница
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // предыдущая страница
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // внутренние страницы
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // следущая страница
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // последняя страницы
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return $buttons;
    }

    public function getPage()
    {
        return $this->renderPageButtons();
    }
}
