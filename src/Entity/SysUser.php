<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysUserRepository")
 */
class SysUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $familyUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $codeMeli;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fatherName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $onlineGUID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    public function getId()
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNameUser(): ?string
    {
        return $this->nameUser;
    }

    public function setNameUser(string $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getFamilyUser(): ?string
    {
        return $this->familyUser;
    }

    public function setFamilyUser(string $familyUser): self
    {
        $this->familyUser = $familyUser;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getCodeMeli(): ?string
    {
        return $this->codeMeli;
    }

    public function setCodeMeli(string $codeMeli): self
    {
        $this->codeMeli = $codeMeli;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(string $fatherName): self
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnlineGUID()
    {
        return $this->onlineGUID;
    }

    /**
     * @param mixed $onlineGUID
     */
    public function setOnlineGUID($onlineGUID)
    {
        $this->onlineGUID = $onlineGUID;
    }


}
