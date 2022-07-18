<?php

declare(strict_types=1);

namespace Gene\SizeGuide\Api;

use Gene\SizeGuide\Api\Data\SizeGuideInterface;

interface SizeGuideRepositoryInterface
{

    /**
     * @param SizeGuideInterface $guide
     * @return mixed
     */
    public function save(SizeGuideInterface $guide);

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $title
     * @return mixed
     */
    public function getByTitle($title);

    /**
     * @param SizeGuideInterface $guide
     * @return mixed
     */
    public function delete(SizeGuideInterface $guide);
}
