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
        if ($params['image'][0]['image']) {
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
        // $this->sendNotification($user, $type);
        //  $this->subscribeUser($user);
        return $user;
    }

    public function getCompaniesList() {
        $query = $this->em->createQuery('select u from Entities:User u join u.AclRole r where r.name=:role_name');
        $query->setParameter(":role_name", \DLConstants::$PARTNER_ROLE);
        $r = $query->getResult();
        return $r;
    }

    /**
     * 
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
                ");
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
     * 
     * @param type $voucher_code
     * @return \NeoMvc\Models\Entity\OrderVoucher
     */
    public function getVoucher($voucher_code,$id_partener) {
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
        $this->em->persist($user);
        $this->em->persist($company);
        $this->em->flush();
        return true;
    }


}
