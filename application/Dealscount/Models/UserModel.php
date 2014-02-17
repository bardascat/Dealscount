<?php

namespace Dealscount\Models;

class UserModel extends AbstractModel {

    /**
     * 
     * @param type $email
     * @return \NeoMvc\Models\Entity\User
     */
    public function checkEmail($email) {


        $userRep = $this->em->getRepository("Entities:User");
        $user = $userRep->findBy(array("email" => $email));
        if (isset($user[0]))
            return $user[0];
        else
            return false;
    }

    public function createUser($params) {
        $checkEmail = $this->checkEmail($params['email']);
        if ($checkEmail) {
            throw new \Exception("Adresa email deja folosita", 1);
        }
        $user = new Entities\User();

        if (!$params['password']) {
            $new_password = $this->randString(10);
            $user->setPassword(sha1($new_password));
            $user->setRealPassword($new_password);
        }
        else
            $user->setPassword(sha1($params['password']));

        $this->em->persist($user);
        $this->em->flush();
        // $this->sendNotification($user, $type);
        //  $this->subscribeUser($user);
        return $user;
    }

    public function resetPassword($email) {
        $user = $this->checkEmail($email);
        if ($user) {
            $new_password = $this->randString(10);
            $user->setPassword(sha1($new_password));
            $user->setRealPassword($new_password);
            ob_start();
            require_once("mailMessages/resetpassword.php");
            $body = ob_get_clean();
            $subject = "Parola contului Oringo a fost resetată";
            NeoMail::getInstance()->genericMail($body, $subject, $email);
            $this->em->persist($user);
            $this->em->flush();
            return true;
        }
        else
            return false;
    }

    private function randString($length, $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count - 1)];
        }
        return $str;
    }

    public function subscribeUser(Entity\User $user = null) {


        return true;
    }

    public function sendNotification(Entity\User $user, $type = "user") {
        $email = $user->getEmail();
        ob_start();
        switch ($type) {
            case "partner": {
                    require_once("mailMessages/contnou_partener.php");
                }break;
            default: {
                    require_once("mailMessages/contnou.php");
                }break;
        }
        $body = ob_get_clean();
        $subject = "Confirmare creare cont partener Oringo";
        NeoMail::getInstance()->genericMail($body, $subject, $email);
    }

    public function updateUser($post) {
        $user = $this->getUserByPk($post['id_user']);
        $role = $this->em->find("Entities:AclRole", $post['id_role']);
        try {
            $user->setAclRole($role);
            $user->postHydrate($post);
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            $e = explode('Integrity', $e->getMessage());
            return $e[1];
        }
        return 1;
    }

    public function updateCompanyDetails($post) {
        $user = $this->getUserByPk($post['id_user']);
        $user->getCompanyDetails()->postHydrate($post);
        $this->em->persist($user);
        $this->em->flush();
        return true;
    }

    /**
     * Cauta userul dupa email si parola.
     * @param type $email
     * @param type $password
     * @return Entities:User
     */
    public function find_user($email, $password = false) {
        $qb = $this->em->createQueryBuilder();
        $qb->select("u")
                ->from("Entities:User", 'u')
                ->where('u.email=:email or u.username=:email');
        if ($password)
            $qb->andWhere('u.password=:password');


        $qb->setParameter(':email', $email)
                ->setParameter(':password', $password);

        $user = $qb->getQuery()->getResult();

        if (isset($user[0]))
            return $user[0];
        else
            return false;
    }

    /**
     * Cauta user dupa id.
     * @param  id int
     * @return  Entities\User
     */
    public function getUserByPk($id, $ORM = true) {

        if (!$ORM)
            $user = $this->em->getConnection()->executeQuery("select users.*,company.company_name from users
                left join company using(id_user)
                where users.id_user=$id")->fetchAll();
        else {
            $user = $this->em->getRepository("Entities:User")->findBy(array("id_user" => $id));
        }
        if (!isset($user[0]))
            return false;
        else
            return $user[0];
    }

    public function deleteUser($id_user) {
        try {
            $dql = $this->em->createQuery("delete from Entities:User u where u.id_user='$id_user'");
            $dql->execute();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function getUsers($page, $limit = 30) {
        try {
            $query = $this->em->createQuery("select users from Entities:User  users join users.AclRole r where r.name!=:role_name order by users.id_user desc")
                    ->setParameter("role_name", \DLConstants::$PARTNER_ROLE)
                    ->setFirstResult(( $page * $limit) - $limit)
                    ->setMaxResults($limit);
            $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
            return $paginator;
        } catch (\Doctrine\ORM\Query\QueryException $e) {
            echo $e->getMessage();
        }
    }

    public function searchUser($keyword) {
        $qb = $this->em->createQueryBuilder();
        $query = $qb->select("u")
                ->from("Entities:User", "u")
                ->where("u.nume like :keyword")
                ->orWhere("u.email like :keyword")
                ->orderBy("u.id_user", "desc")
                ->setParameter(":keyword", "%" . $keyword . '%')
                ->getQuery();

        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($query);
        return $paginator;
    }

    /*     * ************************** FUNCTII PARTENER ******************** */

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

        //cand contul se face cu facebook nu are parola, si o generam automat

        if (!$params['password']) {
            $new_password = $this->randString(10);
            $user->setPassword(sha1($new_password));
        }
        else
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

    /*     * *********************** END PARTENER  ******************** */
}
?>

