<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="job_log")
 */
class JobLog extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_log;

    /**
     *
     * @Column(type="text")
     */
    protected $data;

    /**
     * @Column(type="datetime")
     */
    protected $cdate;

    /**
     * @Column(type="text")
     */
    protected $job_name;
    
    public function getId_log() {
        return $this->id_log;
    }

    public function getData() {
        return $this->data;
    }

    public function getCdate() {
        return $this->cdate;
    }

    public function getJob_name() {
        return $this->job_name;
    }

    public function setId_log($id_log) {
        $this->id_log = $id_log;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setCdate($cdate) {
        $this->cdate = $cdate;
        return $this;
    }

    public function setJob_name($job_name) {
        $this->job_name = $job_name;
        return $this;
    }



}

?>
