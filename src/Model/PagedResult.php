<?php

namespace Emporium\Svc\Alert\Model;

use Krak\Marshal;

use function Krak\DoctrineUtil\repoPaginate;

class PagedResult
{
    public $total;
    public $page_info;
    public $items;

    public static function createEmpty() {
        $res = new self();
        $res->total = 0;
        $res->page_info = [
            'page' => 1,
            'per_page' => 0,
            'max_pages' => 1,
        ];
        $res->items = [];
        return $res;
    }

    public function withMarshaledItems($m) {
        $m = Marshal\map($m);
        $res = new self();
        $res->total = $this->total;
        $res->page_info = $this->page_info;
        $res->items = $m($this->items);
        return $res;
    }

    /** create from a Pagination object where `count` retrieves the total and iterating
        over it returns the current paged set */
    public static function createFromPaginationQuery($query, $page, $per_page) {
        $items = repoPaginate($query, $page, $per_page);
        $res = new self();
        $res->total = count($items);
        $res->items = iterator_to_array($items);
        $res->page_info = [
            'page' => $page,
            'per_page' => $per_page,
            'max_pages' => ceil($res->total / $per_page),
        ];
        return $res;
    }
}