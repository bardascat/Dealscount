<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="subscription_options")
 */
class SubscriptionOption {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_option;

    /**
     *  @Column(type="string")
     */
    protected $name;

    /**
     *  @Column(type="integer")
     */
    protected $sale_price;

    /**
     *  @Column(type="integer")
     */
    protected $price;

    /**
     *  @Column(type="string")
     *  Sunt mai multe tipuri de optiuni
     *  - valabilitate
     *  - oferta_promovata
     *  - oferta_promovata_categorie
     *  - oferta_promovata_subcategorie
     *  - promovare_newsletter
     *  - newsletter_personal
     *  - postare_suplimentara
     */
    protected $type;
    /**
     * //memoram informatii specifice optiunilor, ex pentru valabilitate, anual sau lunar
     *  @Column(type="string")
     */
    protected $details;

    /**
     * //cate zile e valabila aceasta optiune
     *  @Column(type="integer",nullable=true)
     */
    protected $availability_days;

    public function getId_option() {
        return $this->id_option;
    }

    public function getName() {
        return $this->name;
    }

    public function getSale_price() {
        return $this->sale_price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;
    }

    public function setId_option($id_option) {
        $this->id_option = $id_option;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSale_price($sale_price) {
        $this->sale_price = $sale_price;
        return $this;
    }

    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
        return $this;
    }






}

?>
