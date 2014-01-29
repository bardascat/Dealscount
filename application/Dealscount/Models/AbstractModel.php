<?php

namespace Dealscount\Models;

use Doctrine\ORM\EntityManager;

class AbstractModel {

    /**
     *
     * @var EntityManager $em;
     */
    protected $em;

    function __construct() {
        $this->em = \Doctrine::getInstance()->getEm();
    }

}
