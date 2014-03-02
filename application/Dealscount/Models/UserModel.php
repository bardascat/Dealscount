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
        $user->postHydrate($params);
        $roleRep = $this->em->getRepository("Entities:AclRole")->findBy(array("name" => $params['role']));
        if (!isset($roleRep[0])) {
            throw new \Exception("Invalid Role", 1);
        }
        $user->setAclRole($roleRep[0]);
        if (!$params['password']) {
            $new_password = $this->randString(10);
            $user->setPassword(sha1($new_password));
            $user->setRealPassword($new_password);
        } else
            $user->setPassword(sha1($params['password']));

        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit();
            return false;
        }
        $this->sendNotification($user);
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
        } else
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

    public function updateUser($post) {
        $user = $this->getUserByPk($post['id_user']);
        $roleRep = $this->em->getRepository("Entities:AclRole");
        $r = $roleRep->findBy(array("name" => \DLConstants::$USER_ROLE));
        if (!isset($r[0]))
            throw new \Exception("Internal error: User role does not exists", 1);
        else
            $role = $r[0];

        try {
            $user->setAclRole($role);
            $user->postHydrate($post);
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            //nu exista alta exceptie in cazul de fata
            throw new \Exception("Adresa de email este deja in uz", '1');
        }
        return 1;
    }

    public function updatePassword($post) {
        $user = $this->getUserByPk($post['id_user'], true);
        $user->setPassword(sha1($post['new_password']));
        $this->em->persist($user);
        $this->em->flush();
        return true;
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

}
?>

