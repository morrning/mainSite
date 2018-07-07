<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysRollRepository")
 */
class SysRoll
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
    private $rollName;

    /**
     * @ORM\Column(type="integer")
     */
    private $upperID;

    /**
     * @ORM\Column(type="integer")
     */
    private $userID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rollCobTitle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDefaultRoll;

    /**
     * @ORM\Column(type="text")
     */
    private $groups;

    public function getId()
    {
        return $this->id;
    }

    public function getRollName(): ?string
    {
        return $this->rollName;
    }

    public function setRollName(string $rollName): self
    {
        $this->rollName = $rollName;

        return $this;
    }

    public function getUpperID(): ?int
    {
        return $this->upperID;
    }

    public function setUpperID(int $upperID): self
    {
        $this->upperID = $upperID;

        return $this;
    }

    public function getUserID(): ?int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getRollCobTitle(): ?string
    {
        return $this->rollCobTitle;
    }

    public function setRollCobTitle(string $rollCobTitle): self
    {
        $this->rollCobTitle = $rollCobTitle;

        return $this;
    }

    public function getIsDefaultRoll(): ?bool
    {
        return $this->isDefaultRoll;
    }

    public function setIsDefaultRoll(bool $isDefaultRoll): self
    {
        $this->isDefaultRoll = $isDefaultRoll;

        return $this;
    }

    public function getGroups(): ?string
    {
        return $this->groups;
    }

    public function setGroups(string $groups): self
    {
        $this->groups = $groups;

        return $this;
    }
}
