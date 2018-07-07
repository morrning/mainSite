<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 18/05/2018
 * Time: 11:29 AM
 */

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;


class entityMgr extends Controller
{

    private $em;

    function __construct(EntityManagerInterface  $entityManager)
    {
        $this->em = $entityManager;
    }

    //  CHECK FOR EXIST RECORD IN ENTITY
    // -------------------------------------
    public function existById($entityName,$id)
    {
        if(! is_null($this->em->getRepository($entityName)->find($id)))
            return true;
        return false;
    }
    public function existByParams($entityName,$params)
    {
        if(! is_null($this->em->getRepository($entityName)->findOneBy($params)))
            return true;
        return false;
    }

    //  DELETE RECORD
    //-----------------------------------------
    public function deleteById($entityName,$id)
    {
        if($this->existById($entityName,$id))
        {
            $res = $this->em->getRepository($entityName)->find($id);
            $this->em->remove($res);
            $this->em->flush();
        }
    }

    // SELECT ENTITY
    //-------------------------------------------
    public function getById($entityName,$id)
    {
        if($this->existById($entityName,$id))
        {
            return $this->em->getRepository($entityName)->find($id);
        }
    }
    public function select($entity,$params = [],$orders =[])
    {
        return $this->em->getRepository($entity)->findBy($params,$orders);
    }

    public function selectOneRow($entity,$params = [])
    {
        $result =  $this->em->getRepository($entity)->findBy($params);
        if(! is_null($result))
            if(count($result) != 0)
                return $result[0];
        return null;
    }
    public function update($obj)
    {
        $this->em->persist($obj);
        $this->em->flush();
    }

    public function getByPage($entityName,$page=1,$perPage=20)
    {
        return $this->em->createQueryBuilder('q')
            ->select('q')
            ->from($entityName,'q')
            ->setMaxResults($perPage)
            ->setFirstResult($perPage * ($page -1) )
            ->orderBy('q.id','DESC')
            ->getQuery()
            ->execute();
    }

    public function GetCount($entityName,$parameters=[])
    {
        return count($this->select($entityName,$parameters));
    }
    //  INSERT ENTITY TO DATABASE
    //------------------------------------------------
    public function insertEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }

    // ENTITY MANAGER OBJ
    //------------------------------------------------
    public function GetEntityManagerObject()
    {
        return $this->em;
    }
}