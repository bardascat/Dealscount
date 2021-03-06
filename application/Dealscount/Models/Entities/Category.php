<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="categories")
 */
class Category {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_category;

    /** @OneToMany(targetEntity="ItemCategories", mappedBy="category") */
    private $ItemCategories;

    /**
     *
     * @Column(type="string") @var string 
     */
    public $name;

    /**
     *
     * @Column(type="string") @var string 
     */
    protected $slug;

    /**
     * @Column(type="integer",nullable=true) @var string 
     */
    private $id_parent;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    private $thumb;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    private $cover;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    protected $layout;

    /**
     * @Column(type="string",nullable=false) @var string 
     */
    protected $item_type = "offer";

    /**
     * @Column(type="integer",nullable=true) @var string 
     */
    protected $position = 0;

    /**
     * @Column(type="integer",nullable=true) @var string 
     */
    private $nr_items = 0;

    /**
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="id_parent", referencedColumnName="id_category")
     */
    private $parent;

    function __construct() {
        $this->ItemCategories = new ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addItemCategory(ItemCategories $itemCategories) {
        $itemCategories->setCategory($this);
        $this->ItemCategories->add($itemCategories);
    }

    public function getId_category() {
        return $this->id_category;
    }

    public function setId_category($id_category) {
        $this->id_category = $id_category;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        //$this->slug = \NeoMvc\Controllers\controller::makeSlugs($name);
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getId_parent() {
        return $this->id_parent;
    }

    public function setId_parent($id_parent) {
        $this->id_parent = $id_parent;
    }

    public function getThumb() {
        return $this->thumb;
    }

    public function setThumb($photo) {
        $this->thumb = $photo;
    }

    public function getCover() {
        return $this->cover;
    }

    public function setCover($cover) {
        $this->cover = $cover;
    }

    public function getNr_items() {
        return $this->nr_items;
    }

    public function setNr_items($nr_items) {
        $this->nr_items = $nr_items;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getItem_type() {
        return $this->item_type;
    }

    public function setItem_type($item_type) {
        $this->item_type = $item_type;
        return $this;
    }

    /**
     * 
     * @param type $parent
     * @return \Dealscount\Models\Entities\Category
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param type $parent
     * @return \Dealscount\Models\Entities\Category
     */
    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return \Dealscount\Models\Entities\Category
     */
    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
        return $this;
    }

}

?>
