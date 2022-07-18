<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Api\Data;

interface SizeGuideInterface
{

    const ID = 'id';
    const STATUS = 'status';
    const TITLE = 'title';
    const CONTENT = 'content';
    const TABLE_CM = 'table_cm';
    const TABLE_IN = 'table_in';
    const STORE_ID = 'store_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param $content
     * @return mixed
     */
    public function setContent($content);

    /**
     * @return mixed
     */
    public function getTableIn();

    /**
     * @param $tableIn
     * @return mixed
     */
    public function setTableIn($tableIn);

    /**
     * @return mixed
     */
    public function getTableCm();

    /**
     * @param $tableCm
     * @return mixed
     */
    public function setTableCm($tableCm);

    /**
     * @return int[]
     */
    public function getStoreId();

    /**
     * @param int[] $storeId
     * @return $this
     */
    public function setStoreId($storeId);
}
