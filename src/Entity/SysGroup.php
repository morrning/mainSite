<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysGroupRepository")
 */
class SysGroup
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
    private $groupName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $groupTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bundleName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $options;

    public function getId()
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getBundleName(): ?string
    {
        return $this->bundleName;
    }

    public function setBundleName(string $bundleName): self
    {
        $this->bundleName = $bundleName;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(string $des): self
    {
        $this->des = $des;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupTitle()
    {
        return $this->groupTitle;
    }

    /**
     * @param mixed $groupTitle
     */
    public function setGroupTitle($groupTitle): void
    {
        $this->groupTitle = $groupTitle;
    }


}
