<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 01/06/2018
 * Time: 01:27 PM
 */

namespace App\Service;

use App\Service;

class messageMgr
{
    protected $em;
    protected $userMgr;

    // We need to inject this variables later.
    public function __construct(entityMgr $entityManager, userMgr $userMgr)
    {
        $this->em = $entityManager;
        $this->userMgr = $userMgr;
    }

    public function GetThisUserUnreadMessagesCount()
    {
        if(!$this->userMgr->isLogedIn())
            return 0;
        $thisRollID = $this->userMgr->GetThisRollInfo()->getId();
        $result = $this->em->select('App:SysMessage',['reciverID'=>$thisRollID,'dateRecive'=>null]);
        if(is_null($result))
            return 0;
        return count($result);
    }
}