<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 22/05/2018
 * Time: 11:15 AM
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity;

class userMgr
{

    protected $em;
    protected $session;

    function __construct(entityMgr $entityMgr)
    {
        $this->em = $entityMgr;
        $this->session = new Session();
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function DoUserLogin($username, $password){

        $params = ["userName"=>$username,"password"=>md5($password)];
        if($this->em->existByParams('App:SysUser',$params))
        {
            $result = $this->em->selectOneRow('App:SysUser',$params);
            $result->setOnlineGUID($this->session->getId());
            $this->em->update($result);
            return true;
        }

        return false;
    }

    public function isLogedIn()
    {
        $result = $this->GetThisUserInfo();
        if(! is_null($result))
            if($result->getOnlineGUID() != '')
                return true;
        return false;
    }

    public function GetThisUserInfo(){
        $sessionID = $this->session->getId();
        return $this->em->selectOneRow('App:SysUser',['onlineGUID'=>$sessionID]);
    }


    public function DoUserLogout(){
        if($this->isLogedIn()){
            $result = $this->GetThisUserInfo();
            $result->setOnlineGUID('');
            return $this->em->update($result);
        }
    }

    //--------------------------------------------------------------
    public function GetThisRollInfo()
    {
        if($this->isLogedIn()){
            $result = $this->GetThisUserInfo();
            $result = $this->em->selectOneRow('App:SysRoll',['userID'=>$result->getId(),'isDefaultRoll'=>1]);
            if(! is_null($result))
                return $result;
            return null;
        }
    }

    public function GetThisRollTitle()
    {
        return $this->GetThisRollInfo()->getRollCobTitle();
    }

    public function GetRollInfo($id)
    {
        return $this->em->getById('App:SysRoll',$id);
    }

    public function GetThisUserRolls()
    {
        if($this->isLogedIn()){
            $result = $this->GetThisUserInfo();
            $result = $this->em->select('App:SysRoll',['userID'=>$result->getId()]);
            if(! is_null($result))
                return $result;
            return null;
        }
    }

    public function changeDefaultRoll($rollID)
    {
        if($this->isLogedIn())
        {
            $userID = $this->GetThisUserInfo()->getId();
            if($this->em->existByParams('App:SysRoll',['id'=>$rollID, 'userID'=>$userID]))
            {
                $rolls = $this->em->select('App:SysRoll',['userID'=>$userID]);
                foreach ($rolls as $roll)
                {
                    $roll->setIsDefaultRoll(0);
                    $this->em->update($roll);
                }
                $defaultRoll = $this->em->getById('App:SysRoll',$rollID);
                $defaultRoll->setIsDefaultRoll(1);
                $this->em->update($defaultRoll);
                return true;
            }
        }
        return false;
    }

    public function GetAllFilteredRollsListXML($filter)
    {
        if($this->isLogedIn())
        {
            $userID = $this->GetThisUserInfo()->getId();
            if($this->em->existByParams('App:SysRoll',['id'=>$rollID, 'userID'=>$userID]))
            {
                $rolls = $this->em->select('App:SysRoll',['userID'=>$userID]);
                foreach ($rolls as $roll)
                {
                    $roll->setIsDefaultRoll(0);
                    $this->em->update($roll);
                }
                $defaultRoll = $this->em->getById('App:SysRoll',$rollID);
                $defaultRoll->setIsDefaultRoll(1);
                $this->em->update($defaultRoll);
                return true;
            }
        }
    }

    public function GetAllUserCount()
    {
        return count($this->em->select('App:SysUser'));
    }

    public function GetAllRollCount()
    {
        return count($this->em->select('App:SysRoll'));
    }
    /*
     * ****************** Permission part **********************
     */
    public function ThisRollHasPermission($permissionName,$bundle='CORE',$option='')
    {

        if($this->isLogedIn()){
            $GroupIDs = $this->getThisRollInfo()->getGroups();
            $groups = explode(',',$GroupIDs);

            foreach ($groups as $group)
            {
                $params = [
                    'groupName'=>$permissionName,
                    'options'=>$option,
                    'bundleName'=>$bundle
                ];
                $result = $this->em->selectOneRow('App:SysGroup',$params);
                if($group == $result->getId()){
                    return true;
                }
            }
        }
        return false;
    }

    public function AddRollToGroup($rollID,$groupID)
    {
        $obj = $this->em->GetEntityManagerObject();
        $roll = $obj->getRepository('App:SysRoll')->find($rollID);
        $groups = explode(',',$roll->getGroups());
        if(! array_search($groupID,$groups)){
            array_push($groups,$groupID);
            $newGroupList = implode(',',$groups);
            $roll->setGroups($newGroupList);
            $obj->persist($roll);
            $obj->flush();
        }
    }

    public function GetRollsOfGroup($id)
    {
        $obj = $this->em->GetEntityManagerObject();
        return  $obj->getRepository('App:SysRoll')->createQueryBuilder('r')
            ->Where('r.groups = :group')
            ->orWhere('r.groups LIKE :group1')
            ->orWhere('r.groups LIKE :group2')
            ->orWhere('r.groups LIKE :group3')
            ->setParameter('group',  $id)
            ->setParameter('group1', '%,' . $id . ',%')
            ->setParameter('group2', '%' . $id . ',%')
            ->setParameter('group3', '%,' . $id . '%')
            ->getQuery()
            ->getResult();
    }

    public function RemoveRollFromGroup($rollID,$groupID)
    {
        $roll = $this->em->getById('App:SysRoll',$rollID);
        $arrayRolls = explode(',',$roll->getGroups());
        if(in_array($groupID,$arrayRolls)){
            $itemKey = array_search($groupID,$arrayRolls);
            unset($arrayRolls[$itemKey]);
            $newGroupList = implode(',',$arrayRolls);
            $roll->setGroups($newGroupList);
            $this->em->update($roll);
        }
    }

    public function existRoll($id)
    {
        if(! is_null($this->em->getById('App:SysRoll',$id)))
            return true;
        return false;

    }
    public function existUser($id)
    {
        if(! is_null($this->em->getById('App:SysUser',$id)))
            return true;
        return false;
    }

    public function updateRoll($rollID,$rollName,$upperID,$userID)
    {
        $roll = $this->em->getById('App:SysRoll',$rollID);
        $user = $this->em->getById('App:SysUser',$userID);
        $this->changeOtherUserDifaultRoll($userID,$rollID);
        $roll->setRollName($rollName);
        $roll->setRollCobTitle($user->getFullName() . ',' . $rollName);
        $roll->setUpperId($upperID->getId());
        $roll->setUserId($userID->getId());
        $this->em->update($roll);
    }

    public function addRoll($rollName,$upperID,$userID)
    {
        $roll = new Entity\SysRoll();
        $user = $this->em->getById('App:SysUser',$userID);
        $roll->setRollName($rollName);
        $roll->setRollCobTitle($user->getFullName() . ',' . $rollName);
        $roll->setUpperId($upperID->getId());
        $roll->setUserId($userID->getId());
        $roll->setIsDefaultRoll(0);
        $roll->setGroups('0');
        $roll = $this->em->insertEntity($roll);
        $this->changeOtherUserDifaultRoll($userID,$roll->getId());
    }

    public function changeOtherUserDifaultRoll($userID,$rollID)
    {

        $userID = $this->em->getById('App:SysUser',$userID);
        if($this->em->existByParams('App:SysRoll',['id'=>$rollID, 'userID'=>$userID]))
        {
            $rolls = $this->em->select('App:SysRoll',['userID'=>$userID]);
            foreach ($rolls as $roll)
            {
                $roll->setIsDefaultRoll(0);
                $this->em->update($roll);
            }
            $defaultRoll = $this->em->getById('App:SysRoll',$rollID);
            $defaultRoll->setIsDefaultRoll(1);
            $this->em->update($defaultRoll);
            return true;
        }

    }


}