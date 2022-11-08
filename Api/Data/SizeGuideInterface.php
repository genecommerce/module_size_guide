<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Api\Data;

interface SizeGuideInterface
{
    public const ID = 'id';
    public const STATUS = 'status';
    public const TITLE = 'title';
    public const CONTENT = 'content';
    public const TABLE_CM = 'table_cm';
    public const TABLE_IN = 'table_in';
    public const STORE_ID = 'store_id';

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
     * @param mixed $tableIn
     * @return mixed
     */
    public function setTableIn($tableIn);

    /**
     * @return mixed
     */
    public function getTableCm();

    /**
     * @param mixed $tableCm
     * @return mixed
     */
    public function setTableCm($tableCm);

    /**
     * @return int[]
     */
    public function getStoreId(): array;

    /**
     * @param int[] $storeId
     * @return $this
     */
    public function setStoreId(array $storeId): SizeGuideInterface;
}
