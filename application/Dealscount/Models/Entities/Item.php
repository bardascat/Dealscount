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
    protected $brief;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $company_name;

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
     * @OneToMany(targetEntity="ItemTags",mappedBy="item",cascade={"persist","merge"})
     */
    private $tags;

    /**
     * @ManyToOne(targetEntity="User",inversedBy="items")
     * @JoinColumn(name="id_user", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    private $company;

    /**
     *
     * @Column (type="text",nullable=true)
     */
    protected $location;

    /**
     *
     * @Column (type="text")
     */
    protected $city;

    /**
     *
     * @Column(type="text")
     */
    protected $terms;

    /**
     *
     * @Column(type="text")
     */
    protected $benefits;

    /**
     *Pret fara cupon
     * @Column(type="float")
     */
    protected $price;

    /**
     * Pret cu cupon
     * @Column(type="float")
     */
    protected $voucher_price;

    /**
     * Pret de vanzare in sistem. 0 lei pentru cazul de fata
     * @Column(type="float")
     */
    protected $sale_price=0;

    /**
     *
     * @Column(type="float")
     */
    protected $commission;

    /**
     *
     * @Column(type="integer")
     */
    protected $startWith;

    /**
     *
     * @Column(type="datetime")
     */
    protected $start_date;

    /**
     *
     * @Column(type="datetime")
     */
    protected $end_date;

    /**
     *
     * @Column(type="integer")
     */
    protected $voucher_max_limit;

    /**
     *
     * @Column(type="integer")
     */
    protected $voucher_max_limit_user;

    /**
     *
     * @Column(type="datetime")
     */
    protected $voucher_start_date;

    /**
     *
     * @Column(type="datetime")
     */
    protected $voucher_end_date;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $latitude;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $longitude;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $meta_title;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $meta_desc;

    /**
     * @ManyToOne(targetEntity="User",inversedBy="items")
     * @JoinColumn(name="id_operator", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    protected $operator;

    /**
     * @Column(type="date",nullable=true)
     */
    protected $updated_date;

    /**
     * @Column(type="integer",nullable=true)
     */
    protected $updated_by;

    public function __construct() {
        $this->createdDate = new \DateTime("now");
        $this->images = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->ItemCategories = new ArrayCollection();
        $this->ProductVariants = new ArrayCollection();
    }

    public function getCreatedDate() {
        return $this->createdDate->format("d-m-Y H:i");
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

    public function addTag(ItemTags $tag) {
        $tag->setItem($this);
        $this->tags->add($tag);
    }

    public function getTags() {
        return $this->tags;
    }

    public function addImage(ItemImage $image) {
        $image->setItem($this);
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
     * @return \Dealscount\Models\Entities\ItemImage
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
        if (!file_exists($itemImages[0]->getThumb()))
            return 'application_uploads/items/image_not_found.png';

        if ($type == "thumb")
            return ($itemImages[0]->getThumb());

        if ($type == "image")
            return ($itemImages[0]->getImage());
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
     * @return \Dealscount\Models\Entities\User
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
     * @return \Dealscount\Models\Entities\ItemStats
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

    public function getBrief() {
        return $this->brief;
    }

    public function setBrief($brief) {
        $this->brief = $brief;
        return $this;
    }

    public function getCompany_name() {
        return $this->company_name;
    }

    public function setCompany_name($company_name) {
        $this->company_name = $company_name;
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getTerms() {
        return $this->terms;
    }

    public function setTerms($terms) {
        $this->terms = $terms;
        return $this;
    }

    public function getBenefits() {
        return $this->benefits;
    }

    public function setBenefits($benefits) {
        $this->benefits = $benefits;
        return $this;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function getSale_price() {
        return $this->sale_price;
    }

    public function setSale_price($sale_price) {
        $this->sale_price = $sale_price;
        return $this;
    }

    public function getCommission() {
        return $this->commission;
    }

    public function setCommission($commission) {
        $this->commission = $commission;
        return $this;
    }

    public function getStartWith() {
        return $this->startWith;
    }

    public function setStartWith($startWith) {
        $this->startWith = $startWith;
        return $this;
    }

    public function getStart_date() {
        return $this->start_date;
    }

    public function setStart_date($start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function getEnd_date() {
        return $this->end_date;
    }

    public function setEnd_date($end_date) {
        $this->end_date = $end_date;
        return $this;
    }

    public function getVoucher_max_limit() {
        return $this->voucher_max_limit;
    }

    public function setVoucher_max_limit($voucher_max_limit) {
        $this->voucher_max_limit = $voucher_max_limit;
        return $this;
    }

    public function getVoucher_max_limit_user() {
        return $this->voucher_max_limit_user;
    }

    public function setVoucher_max_limit_user($voucher_max_limit_user) {
        $this->voucher_max_limit_user = $voucher_max_limit_user;
        return $this;
    }

    public function getVoucher_start_date() {
        return $this->voucher_start_date->format("Y-m-d");
    }

    public function setVoucher_start_date($voucher_start_date) {
        $this->voucher_start_date = $voucher_start_date;
        return $this;
    }

    public function getVoucher_end_date() {
        return $this->voucher_end_date->format("Y-m-d");
    }

    public function setVoucher_end_date($voucher_end_date) {
        $this->voucher_end_date = $voucher_end_date;
        return $this;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    public function getAuthorName() {
        return $this->getOperator()->getFirstname() . ' ' . $this->getOperator()->getLastname();
    }

    public function getUpdated_date() {
        return $this->updated_date;
    }

    public function setUpdated_date($updated_date) {
        $this->updated_date = $updated_date;
        return $this;
    }

    public function getMeta_title() {
        return $this->meta_title;
    }

    public function setMeta_title($meta_title) {
        $this->meta_title = $meta_title;
        return $this;
    }

    public function getMeta_desc() {
        return $this->meta_desc;
    }

    public function setMeta_desc($meta_desc) {
        $this->meta_desc = $meta_desc;
        return $this;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\User
     */
    public function getOperator() {
        return $this->operator;
    }

    public function setOperator($operator) {
        $this->operator = $operator;
        return $this;
    }

    public function getUpdated_by() {
        return $this->updated_by;
    }

    public function setUpdated_by($updated_by) {
        $this->updated_by = $updated_by;
        return $this;
    }

    /**
     * Metode particulare
     */
    public function getRemainingHours() {

        $date1 = date("Y-m-d H:i:s");
        $date2 = date("Y-m-d");
        $diff = abs(strtotime($date2 . ' 23:59:59') - strtotime($date1));

        return round($diff / 3600);
    }

    public function getPercentageDiscount() {
        return round(100 - ($this->getSale_price() * 100 ) / $this->getPrice());
    }
    
    public function getVoucher_price() {
        return $this->voucher_price;
    }

    public function setVoucher_price($voucher_price) {
        $this->voucher_price = $voucher_price;
        return $this;
    }




}

?>
