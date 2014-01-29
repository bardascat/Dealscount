<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="items")
 */
use Doctrine\Common\Collections\ArrayCollection;

class Item extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_item;

    /**
     *
     * @Column(type="integer") @var string 
     */
    private $id_user;

    /**
     *
     * @Column(type="string") @var string 
     */
    protected $name;

    /**
     *
     * @Column(type="string") @var string 
     */
    protected $slug;

    /**
     *
     * @Column(type="datetime")
     */
    protected $createdDate;

    /**
     *
     * @Column(type="integer") @var float
     */
    protected $active = 1;

    /**
     *
     * @Column(type="integer") @var float
     */
    protected $blackfriday = 0;

    /**
     *
     * @Column(type="integer",nullable=true) @var float
     */
    private $id_stats;

    /** @OneToOne(targetEntity="ItemStats",cascade={"persist"})
     * @JoinColumn(name="id_stats", referencedColumnName="id_stats")
     */
    private $stats;

    /** @OneToMany(targetEntity="ItemCategories", mappedBy="item",cascade={"persist","merge"}) */
    private $ItemCategories;

    /**
     * @OneToMany(targetEntity="ItemImage",mappedBy="item",cascade={"persist","merge"})
     * @OrderBy({"primary_image" = "desc","id_image"="desc"})
     */
    private $images;

    /**
     * @ManyToOne(targetEntity="User",inversedBy="items")
     * @JoinColumn(name="id_user", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    private $company;


    public function __construct() {
        $this->createdDate = new \DateTime("now");
        $this->images = new ArrayCollection();
        $this->ItemCategories = new ArrayCollection();
        $this->ProductVariants = new ArrayCollection();
    }

    public function getCreatedDate() {
        return $this->createdDate->format("d-m-Y");
    }

    public function getIdItem() {
        return $this->id_item;
    }

    public function setIdItem($id_item) {
        $this->id_item = $id_item;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function addImage(ItemImage $image) {
        $image->setProduct($this);
        if (!($this->images instanceof ArrayCollection))
            $this->images = new ArrayCollection ();

        $this->images->add($image);
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function addCategory(ItemCategories $itemCategories) {
        $itemCategories->setItem($this);
        $this->ItemCategories->add($itemCategories);
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\Category
     */
    public function getCategory() {
        if (count($this->ItemCategories) < 1)
            return false;

        $firstCategory = $this->ItemCategories[0];
        $category = $firstCategory->getCategory();
        return $category;
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\ItemImage
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Intoarce poza principala daca exista, sau  in caz contratr o poza clasica not found.
     * @return \NeoMvc\Models\Entity\ItemImage
     */
    public function getMainImage($type = "thumb") {
        $itemImages = $this->getImages();
        if ($type == "thumb")
            return ($itemImages[0]->getThumb());

        if ($type == "image")
            return ($itemImages[0]->getImage());

        return (URL . "images/image_not_found.jpg");
    }

    public function getId_item() {
        return $this->id_item;
    }

    public function setId_item($id_item) {
        $this->id_item = $id_item;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\User
     */
    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }


    /**
     * 
     * Metoda folosita pentru a repopula inputurile din forms
     */
    public function getIterationArray() {

        $iteration = array();
        foreach ($this as $key => $value) {
            if (!is_object($value) || ($value instanceof \DateTime))
                $iteration[$key] = $value;
        }

        //adaugam detaliile
        $ItemDetails = $this->getItemDetails();

        $extra = $ItemDetails->getIterationArray();

        foreach ($extra as $key => $value)
            $iteration[$key] = $value;

        //adaugam compania
        $company = $this->getCompany();
        if (!$company)
            $iteration['id_company'] = null;
        else
            $iteration['id_company'] = $company->getId_user();

        return $iteration;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\ItemStats
     */
    public function getStats() {
        return $this->stats;
    }

    public function setStats($stats) {
        $this->stats = $stats;
    }

    public function getId_stats() {
        return $this->id_stats;
    }

    public function setId_stats($id_stats) {
        $this->id_stats = $id_stats;
    }

    public function getBlackfriday() {
        return $this->blackfriday;
    }

    public function setBlackfriday($blackfriday) {
        $this->blackfriday = $blackfriday;
    }

}

?>
