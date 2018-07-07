<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysHelpRepository")
 */
class SysHelp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $helpID;

    /**
     * @ORM\Column(type="text")
     */
    private $HelpMsg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $HelpBundle;

    public function getId()
    {
        return $this->id;
    }

    public function getHelpID(): ?int
    {
        return $this->helpID;
    }

    public function setHelpID(int $helpID): self
    {
        $this->helpID = $helpID;

        return $this;
    }

    public function getHelpMsg(): ?string
    {
        return $this->HelpMsg;
    }

    public function setHelpMsg(string $HelpMsg): self
    {
        $this->HelpMsg = $HelpMsg;

        return $this;
    }

    public function getHelpBundle(): ?string
    {
        return $this->HelpBundle;
    }

    public function setHelpBundle(string $HelpBundle): self
    {
        $this->HelpBundle = $HelpBundle;

        return $this;
    }
}
