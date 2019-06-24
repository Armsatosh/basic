<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->username = $this->getEmail();
        $this->usernameCanonical = $this->getEmail();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate() {
        $this->username = $this->getEmail();
        $this->usernameCanonical = $this->getEmail();
    }

}
