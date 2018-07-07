<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysMessageRepository")
 */
class SysMessage
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
    private $senderID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reciverID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateSend;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateRecive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSenderID()
    {
        return $this->senderID;
    }

    /**
     * @param mixed $senderID
     */
    public function setSenderID($senderID)
    {
        $this->senderID = $senderID;
    }

    /**
     * @return mixed
     */
    public function getReciverID()
    {
        return $this->reciverID;
    }

    /**
     * @param mixed $reciverID
     */
    public function setReciverID($reciverID)
    {
        $this->reciverID = $reciverID;
    }

    /**
     * @return mixed
     */
    public function getDateSend()
    {
        return $this->dateSend;
    }

    /**
     * @param mixed $dateSend
     */
    public function setDateSend($dateSend)
    {
        $this->dateSend = $dateSend;
    }

    /**
     * @return mixed
     */
    public function getDateRecive()
    {
        return $this->dateRecive;
    }

    /**
     * @param mixed $dateRecive
     */
    public function setDateRecive($dateRecive)
    {
        $this->dateRecive = $dateRecive;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }



}
