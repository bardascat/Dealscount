<?php

namespace Dealscount\Models;

/**
 *
 * @author Neo aka Bardas Catalin
 */
class PartnerModel extends AbstractModel {

    public function createPartner($params) {
        $checkEmail = $this->checkEmail($params['email']);
        if ($checkEmail) {
            throw new \Exception("Adresa email deja folosita", 1);
        }
        $user = new Entities\User();
        $user->postHydrate($params);
        $company = new Entities\Company();
        $company->setStatus(\DLConstants::$PARTNER_PENDING);

        if (isset($params['image'][0]['image']) && $params['image'][0]['image']) {
            $company->setImage($params['image'][0]['image']);
        }
        $company->postHydrate($params);
        $user->setPassword(sha1($params['password']));
        $roleRep = $this->em->getRepository("Entities:AclRole");
        $r = $roleRep->findBy(array("name" => \DLConstants::$PARTNER_ROLE));
        if (!isset($r[0]))
            exit('No partner role defined');
        else
            $partner = $r[0];

        $user->setAclRole($partner);
        $user->setCompany($company);
        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (Doctrine\DBAL\DBALException $e) {
            
        }
        $this->sendNotification($user);
//  $this->subscribeUser($user);
        return $user;
    }

    public function checkEmail($email) {


        $userRep = $this->em->getRepository("Entities:User");
        $user = $userRep->findBy(array("email" => $email));
        if (isset($user[0]))
            return $user[0];
        else
            return false;
    }

    public function sendNotification(Entities\User $user) {
        $email = $user->getEmail();
        ob_start();
        switch ($user->getAclRole()->getName()) {
            case \DLConstants::$PARTNER_ROLE: {
                    require_once("application/views/mailMessages/contnou_partener.php");
                }break;
            default: {
                    require_once("application/views/mailMessages/contnou.php");
                }break;
        }
        $body = ob_get_clean();
        $subject = "Confirmare creare cont " . \DLConstants::$WEBSITE_COMMERCIAL_NAME;
        \NeoMail::genericMail($body, $subject, $email);
    }

    public function getCompaniesList() {
        $query = $this->em->createQuery('select u from Entities:User u join u.AclRole r where r.name=:role_name');
        $query->setParameter(":role_name", \DLConstants::$PARTNER_ROLE);
        $r = $query->getResult();
        return $r;
    }

    /**
     * @param type $id_company
     * @return \NeoMvc\Models\Entity\User
     */
    public function getCompanyByPk($id_company) {
        $query = $this->em->createQuery('select u from Entities:User u join u.AclRole r where r.name=:role_name and u.id_user=:id_user');
        $query->setParameter(":role_name", \DLConstants::$PARTNER_ROLE);
        $query->setParameter(":id_user", $id_company);
        $partner = $query->getResult();
        if (isset($partner[0]))
            return $partner[0];
        else
            return false;
    }

    public function updateCompany($post) {
        /* @var $user Entity\User */
        $user = $this->em->find("Entities:User", $post['id_user']);
        $user->postHydrate($post);
        /* @var $company Entity\Company */
        $company = $user->getCompanyDetails();
        $company->postHydrate($post);


        if (isset($post['image'][0]['image']))
            $company->setImage($post['image'][0]['image']);

        $this->em->persist($user);
        $this->em->flush();
        return true;
    }

    public function createNewsletter($params, $partner) {
        $newsletter = new Entities\PartnerNewsletter();
        $newsletter->setStatus(\DLConstants::$NEWSLETTER_PENDING);
        $newsletter->postHydrate($params);
        $filters = array(
            "age" => $params['age'],
            "sex" => $params['sex'],
            "cities" => $params['cities']
        );
        $newsletter->setFilters(json_encode($filters));

//adaugam ofertele active ale utilizatorului
        try {
            $offersArray = $this->em->createQuery("select items.id_item from Entities:Item items 
                where items.id_user=:id_user
                and items.active=1
                and items.end_date>CURRENT_TIMESTAMP()
                and items.start_date<=CURRENT_TIMESTAMP()
                ")
                    ->setParameter(":id_user", $partner->getId_user())
                    ->getArrayResult();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $offers = array();
        foreach ($offersArray as $key => $offer) {
            $offers[] = $offer['id_item'];
        }
        $newsletter->setOffers(json_encode($offers));
        $partner->addPartnerNewsletter($newsletter);
        $this->em->persist($partner);
        $this->em->flush();

        return true;
    }

    /**
     * Intoarce orasele utilizatorilor pe baza carora se poate programa newsletterul
     */
    public function getActiveCities() {
        $city = $this->em->createQuery("select distinct users.city from Entities:User users")
                ->getArrayResult();
        return $city;
    }

    public function suspendNewsletter($id_newsletter, $partner) {
        $newsletter = $this->em->find("Entities:PartnerNewsletter", $id_newsletter);
        if (!$newsletter)
            throw new \Exception("Eroare: Id newsletter incorect");
        if ($newsletter->getUser()->getId_user() != $partner->getId_user()) {
            throw new \Exception("Eroare: Newsletterul " . $id_newsletter . " nu apartine partenerului");
        }
        if ($newsletter->getScheduled() <= date("Y-m-d") || $newsletter->getStatus() == \DLConstants::$NEWSLETTER_SENT) {
            throw new \Exception("Eroare: Newsletterul nu mai poate fi anulat!");
        }

        $newsletter->setStatus(\DLConstants::$NEWSLETTER_SUSPENDED);
        $this->em->persist($newsletter);
        $this->em->flush();
        return true;
    }

    /**
     * 
     * @param type $id_newsletter
     * @param type $partner
     * @return \Dealscount\Models\Entities\PartnerNewsletter
     * @throws \Exception
     */
    public function getNewsletter($id_newsletter, $partner) {
        $newsletter = $this->em->find("Entities:PartnerNewsletter", $id_newsletter);
        if (!$newsletter)
            throw new \Exception("Eroare: Id newsletter incorect");
        if ($newsletter->getUser()->getId_user() != $partner->getId_user()) {
            throw new \Exception("Eroare: Newsletterul " . $id_newsletter . " nu apartine partenerului");
        }

        return $newsletter;
    }

    /**
     * @author Corneliu Iancu <corneliu.iancu@opti.ro>
     */
    public function getVouchers($id_partner) {
        try {

            $dql = $this->em->createQuery("SELECT ov,oi
                FROM Entities:OrderVoucher ov 
                JOIN ov.orderItem oi
                JOIN oi.item i
                WHERE i.id_user = :id_partener
                order by ov.id_voucher desc
                ")
                    ->setMaxResults(100);
            $dql->setParameter(":id_partener", $id_partner);
            $result = $dql->getResult();

            if (count($result) < 0)
                return false;
            else
                return $result;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }

        return $id_partner;
    }

    /**
     * @param type $voucher_code
     * @return \NeoMvc\Models\Entity\OrderVoucher
     */
    public function getVoucher($voucher_code, $id_partener) {
        $dql = $this->em->createQuery("SELECT ov,oi
                FROM Entities:OrderVoucher ov 
                JOIN ov.orderItem oi
                JOIN oi.item i
                WHERE i.id_user = :id_partener AND ov.code = :voucher_code
                ");
        $dql->setParameter(":id_partener", $id_partener);
        $dql->setParameter(":voucher_code", $voucher_code);
        $voucher = $dql->getResult();

        if (isset($voucher[0])) {
            return $voucher[0];
        } else {
            return false;
        }
    }

    public function changeVoucherStatus($voucher_code) {
        $voucher = $this->em->getRepository("Entities:OrderVoucher")->findBy(array("code" => $voucher_code));
        if (isset($voucher[0])) {
            $voucher[0]->setUsed(1);
            $voucher[0]->setUsed_At(new \DateTime);
            $this->em->persist($voucher[0]);
            $this->em->flush();

            return $voucher_code;
        } else {
            return false;
        }
    }

    public function updateCompanyDetails($post, Entities\User $user) {
        $company = $user->getCompanyDetails();
        $company->setCompany_name($post['company_name']);
        $company->setCif($post['cif']);
        $company->setRegCom($post['regCom']);
        $company->setBank($post['bank']);
        $company->setIban($post['iban']);
        $user->setAddress($post['address']);
        $user->setPhone($post['phone']);
        $user->setEmail($post['email']);
        $user->setLastname($post['lastname']);
        $user->setFirstname($post['firstname']);
        $user->setCity($post['city']);
        $this->em->persist($user);
        $this->em->persist($company);
        $this->em->flush();
        return true;
    }

    private function generateInvoice(Entities\SubscriptionOptionOrder &$order) {
        if ($order->getInvoice())
            return false;

        $invoice = New Entities\Invoice();
        //daca este livrat si nu are factura generata, o generam acum in baza de date
        $invoice->setActive(1);
        $invoice->setTotal($order->getTotal());
        $invoice->setNumber($this->getInvoiceNumber());
        $invoice->setTva(24);
        $products = array(
            "id" => $order->getOption()->getId_option(),
            "nume" => $order->getOption()->getName(),
            "details" => $order->getOption()->getDetails(),
            "price" => $order->getOption()->getSale_price(),
            "quantity" => $order->getQuantity(),
            "type" => $order->getOption()->getType()
        );
        $invoice->setComapany_info($this->getCompanyInfo($order->getCompany()));
        $invoice->setSupplier_info($this->getSupplier_info());
        $invoice->setProducts(json_encode($products));
        $invoice->setSeries(\DLConstants::$INVOICE_SERIES);
        $order->setInvoice($invoice);
        $order->getCompany()->addInvoice($invoice);
        $this->em->persist($invoice);
    }

    private function getCompanyInfo(Entities\Company $company) {
        $data = array(
            "name" => $company->getCompany_name(),
            "reg_com" => $company->getRegCom(),
            "cui" => $company->getCif(),
            "adresa" => $company->getAddress(),
            "iban" => $company->getIban(),
            "banca" => $company->getBank()
        );
        return json_encode($data);
    }

    private function getSupplier_info() {
        $data = array(
            "name" => \DLConstants::$SUPPLIER_NAME,
            "reg_com" => \DLConstants::$SUPPLIER_REG_COM,
            "cui" => \DLConstants::$SUPPLIER_CUI,
            "adresa" => \DLConstants::$SUPPLIER_ADDRESS,
            "iban" => \DLConstants::$SUPPLIER_IBAN,
            "banca" => \DLConstants::$SUPPLIER_BANK,
        );
        return json_encode($data);
    }

    private function getInvoiceNumber() {
        $conn = $this->em->getConnection();
        $query = "select max(number) as max_invoice from invoices";
        $data = $conn->executeQuery($query)->fetchAll();

        if ($data[0]) {
            return ($data[0]['max_invoice'] + 1);
        } else {
            return "error";
        }
    }

    /**
     * 
     * @param type $id_invoice
     * @param \Dealscount\Models\Entities\User $partner
     * @return \Dealscount\Models\Entities\Invoice
     * @throws \Exception
     */
    public function getInvoice($id_invoice, Entities\User $partner) {
        /* @var  $invoice \Dealscount\Models\Entities\Invoice */

        $invoice = $this->em->find("Entities:Invoice", $id_invoice);
        if (!$invoice)
            throw new \Exception('Factura nu exista');
        if ($invoice->getCompany()->getId_company() != $partner->getCompanyDetails()->getId_company())
            throw new \Exception('Factura apartine altui utilizator');

        return $invoice;
    }

    public function generateInvoiceFile(Entities\Invoice $invoice) {
        $filename = $invoice->getSeries();
        $filename.=$invoice->getNumber() . '.pdf';
        $file = "application_uploads/invoices/" . $filename;
        ob_start();
        require_once('application/views/pdf/invoice.php');
        $invoiceHtml = ob_get_clean();
        require_once("application/libraries/mpdf54/mpdf.php");
        $mpdf = new \mPDF('c', "A4", '', '', 2, 2, 2, 2, 0, 0);
        $stylesheet = "body { font-family:Tahoma}";
        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($invoiceHtml);
        $mpdf->Output($file);
        return $file;
    }

    /**
     * Observatie:
     * Din punct de vedere al specificatiilor exista 2 abonamente(lunar si anual) si optiuni pe care le adaugam la aceste abonamente
     * Pentru a simplifica schema bazei de date am considerat cele 2 abonamente tot niste optiuni de valabilitate.
     * Practic o optiune din cele 2 ofera valabilitate 1 luna sau 12 luni exact ca un abonament.
     * @return \Dealscount\Models\Entities\SubscriptionOption
     * @param $type valabilitate sau option
     */
    public function getSubscriptionOptions($type = false) {
        $rep = $this->em->getRepository("Entities:SubscriptionOption");
        if ($type){
            $ab = $rep->findBy(array("type" => $type));
        }
        else
            $ab = $rep->findAll();
        return $ab;
    }

    /**
     * @return \Dealscount\Models\Entities\SubscriptionOption
     */
    public function getSubscriptionOption($id_option) {
        return $this->em->find("Entities:SubscriptionOption", $id_option);
    }

    public function updateOption($params) {
        $option = $this->getSubscriptionOption($params['id_option']);
        $option->postHydrate($params);
        $this->em->persist($option);
        $this->em->flush();
    }

    /**
     * @return \Dealscount\Models\Entities\SubscriptionOptionOrder
     */
    public function getSubscriptionOptionOrder($order_code) {
        $rep = $this->em->getRepository("Entities:SubscriptionOptionOrder");
        $ab = $rep->findOneBy(array("order_number" => $order_code));
        return $ab;
    }

    /**
     * @return \Dealscount\Models\Entities\SubscriptionOptionOrder
     */
    public function updateSubscriptionOrder(Entities\SubscriptionOptionOrder $order) {
        $this->em->persist($order);
        $this->em->flush();
    }

    public function confirmSubscriptionOptionOrder($order_code) {
        $order = $this->getSubscriptionOptionOrder($order_code);

        if (!$order)
            show_404();

        if ($order->getPayment_status() == \DLConstants::$PAYMENT_STATUS_CONFIRMED)
            exit('Plata a fost deja confirmata');

        $company = $order->getCompany();
        $order->setPayment_status(\DLConstants::$PAYMENT_STATUS_CONFIRMED);
        $this->em->persist($order);


        $option = $order->getOption();
        /**
         * Acum in functie de tipul optiunii, o implementam
         */
        switch ($option->getType()) {
            case \DLConstants::$OPTIUNE_VALABILITATE: {
                    //verificam daca e lunar sau anual
                    if ($option->getDetails() == "anual") {
                        $add = " 1 year";
                    } else if ($option->getDetails() == "lunar") {
                        $add = " 1 month";
                    }
                    /* adaugam valabilitate in tabelul company_details
                     * daca contul este deja expirat atunci adaugam valabilitatea incepand cu ziua curenta
                     * - altfel incepand cu data cand expira
                     */
                    if (!$company->getAvailable_to()) {
                        //este prima activare
                        $company->setAvailable_from(new \DateTime(date("Y-m-d")));
                        $company->setAvailable_to(new \DateTime(date("Y-m-d", strtotime(date("Y-m-d") . ' ' . $add))));
                    } else {
                        if ($company->getAvailable_to() < date("Y-m-d")) {
                            $company->setAvailable_to(new \DateTime(date("Y-m-d", strtotime(date("Y-m-d") . ' ' . $add))));
                        } else {
                            $company->setAvailable_to(new \DateTime(date("Y-m-d", strtotime($company->getAvailable_to()->format("Y-m-d") . ' ' . $add))));
                        }
                    }
                    $this->em->persist($company);
                }break;
        }

        $this->generateInvoice($order);
        $this->em->flush();
    }

    // end abonamente
}
