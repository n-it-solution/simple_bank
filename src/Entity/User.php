<?php
// src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string $phoneNumber
     *
     * @ORM\Column(name="phoneNumber", type="string", length=20,unique=true)
     */
    protected $phoneNumber;
    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    protected $firstname;
    /**
     *
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    protected $lastname;
    /**
     *
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    protected $gender;
    /**
     *
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=1)
     */
    protected $type;
    /**
     *
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Client_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Api_key;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Api_expire;
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }
    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return User
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getClientToken(): ?string
    {
        return $this->Client_token;
    }

    public function setClientToken(?string $Client_token): self
    {
        $this->Client_token = $Client_token;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->Api_key;
    }

    public function setApiKey(?string $Api_key): self
    {
        $this->Api_key = $Api_key;

        return $this;
    }

    public function getApiExpire(): ?string
    {
        return $this->Api_expire;
    }

    public function setApiExpire(?string $Api_expire): self
    {
        $this->Api_expire = $Api_expire;

        return $this;
    }

}