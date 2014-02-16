<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="acl")
 */
class Acl extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_acl;

    /**
     * @Column(type="integer") @var string 
     */
    protected $id_role;

    /**
     * @Column(type="integer") @var string 
     */
    protected $id_resource;

    /**
     * @Column(type="string") @var string 
     */
    protected $action = "allow";

    /**
     * @ManyToOne(targetEntity="AclRole")
     * @JoinColumn(name="id_role", referencedColumnName="id_role" ,onDelete="CASCADE")
     */
    protected $role;

    /**
     * @ManyToOne(targetEntity="AclResource")
     * @JoinColumn(name="id_resource", referencedColumnName="id_resource" ,onDelete="CASCADE")
     */
    protected $resource;

    function __construct() {
        
    }

    public function getId_acl() {
        return $this->id_acl;
    }

    public function getId_role() {
        return $this->id_role;
    }

    public function getId_resource() {
        return $this->id_resource;
    }

    public function getRole() {
        return $this->role;
    }

    public function getResource() {
        return $this->resource;
    }

    public function setId_acl($id_acl) {
        $this->id_acl = $id_acl;
        return $this;
    }

    public function setId_role($id_role) {
        $this->id_role = $id_role;
        return $this;
    }

    public function setId_resource($id_resource) {
        $this->id_resource = $id_resource;
        return $this;
    }

    public function setRole($role) {
        $this->role = $role;
        return $this;
    }

    public function setResource($resource) {
        $this->resource = $resource;
        return $this;
    }
    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }



}

?>
