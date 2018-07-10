<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 09/06/2018
 * Time: 11:32 AM
 */

namespace App\Service;


use App\Entity\SysLog;

class logMgr
{

    private $em;
    private $userMgr;

    function __construct(entityMgr $entityMgr, userMgr $userMgr)
    {
        $this->em = $entityMgr;
        $this->userMgr = $userMgr;
    }

    public function log($des,$bundle,$type='اطلاعات',$options = NULL)
    {
        $log = new SysLog();
        $log->setBundlename($bundle);
        $log->setDateSubmit(time());
        $log->setSubmitter($this->userMgr->GetThisUserInfo()->getId());
        $log->setLogDes($des);
        $log->setType($type);
        $log->setOptions($options);
        $this->em->insertEntity($log);
    }

}