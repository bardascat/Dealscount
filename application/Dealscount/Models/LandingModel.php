<?php

namespace Dealscount\Models;

class LandingModel extends AbstractModel {

    public function dummyTest(Entities\User $user) {
        $this->em->persist($user);
        $this->em->flush();
    }

}
?>

