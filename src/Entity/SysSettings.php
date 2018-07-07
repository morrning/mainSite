<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysSettingsRepository")
 */
class SysSettings
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteName;

    /**
     * @ORM\Column(type="integer")
     */
    private $isOffline;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prodectKey;

    public function getId()
    {
        return $this->id;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(?string $siteName): self
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getIsOffline(): ?int
    {
        return $this->isOffline;
    }

    public function setIsOffline(int $isOffline): self
    {
        $this->isOffline = $isOffline;

        return $this;
    }

    public function getProdectKey(): ?string
    {
        return $this->prodectKey;
    }

    public function setProdectKey(?string $prodectKey): self
    {
        $this->prodectKey = $prodectKey;

        return $this;
    }
}
