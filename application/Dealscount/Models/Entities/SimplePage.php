<?php

namespace Dealscount\Models\Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="simple_pages")
 */
class SimplePage extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_page;

    /**
     *
     * @Column(type="string") @var string 
     */
    protected $name;

    /**
     * @Column(type="string") @var string 
     */
    protected $slug;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    protected $layout;
    /**
     * @Column(type="text",nullable=true) @var string 
     */
    protected $content;
    

    public function getId_page() {
        return $this->id_page;
    }

    public function setId_page($id_page) {
        $this->id_page = $id_page;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

        public function getIterationArray() {

        $iteration = array();
        foreach ($this as $key => $value) {
            if (!is_object($value) || ($value instanceof \DateTime))
                $iteration[$key] = $value;
        }

        return $iteration;
    }

}

?>
