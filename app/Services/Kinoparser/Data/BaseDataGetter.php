<?php

namespace App\Services\Kinoparser\Data;

use App\Contracts\Kinoparser\DataGetterInterface;

/**
 * Description of BaseData
 *
 * @author Кирилл
 */
abstract class BaseDataGetter
{

    /**
     * @var DataGetterInterface
     */
    private $data;

    public function __construct(DataGetterInterface $data)
    {

        $this->data = $data;
    }

    public function getData($url): string
    {
        return $this->data->getData($url);
    }

}
