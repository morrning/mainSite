<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysLogRepository")
 */
class SysLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $logDes;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $dateSubmit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bundlename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $options;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $submitter;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLogDes()
    {
        return $this->logDes;
    }

    /**
     * @param mixed $logDes
     */
    public function setLogDes($logDes)
    {
        $this->logDes = $logDes;
    }

    /**
     * @return mixed
     */
    public function getDateSubmit()
    {
        return $this->dateSubmit;
    }

    /**
     * @param mixed $dateSubmit
     */
    public function setDateSubmit($dateSubmit)
    {
        $this->dateSubmit = $dateSubmit;
    }

    /**
     * @return mixed
     */
    public function getBundlename()
    {
        return $this->bundlename;
    }

    /**
     * @param mixed $bundlename
     */
    public function setBundlename($bundlename)
    {
        $this->bundlename = $bundlename;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getSubmitter()
    {
        return $this->submitter;
    }

    /**
     * @param mixed $submitter
     */
    public function setSubmitter($submitter)
    {
        $this->submitter = $submitter;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}