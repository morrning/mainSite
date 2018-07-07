<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 04/06/2018
 * Time: 09:39 AM
 */

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form as Form;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormError;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use App\Form\Type;
use App\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class gridMgr
{
    protected $em;
    protected $AppFolder;
    protected $userMgr;
    protected $twig;
    protected $jdate;
    protected $entityMgr;

    //----------------------------------

    //----------------------------------

    // We need to inject this variables later.
    public function __construct(EntityManagerInterface $entityManager, userMgr $userMgr, EngineInterface $templating,jdateMgr $jdateMgr,entityMgr $entityMgr)
    {
        $this->em = $entityManager;

        $this->AppFolder = realpath(__DIR__.'/../');
        $this->entityMgr = $entityMgr;
        $this->userMgr = $userMgr;
        $this->twig = $templating;
        $this->jdate = $jdateMgr;
    }
    public function getPattern($EntityPattern)
    {
        return Yaml::parse(file_get_contents($this->AppFolder . '/GridPattern/' . $EntityPattern));

    }

    //this function return table header in array mode
    protected function getTitles($yml)
    {
        $items = $yml['grid']['items'];
        $titles =[];
        foreach ($items as $item)
            array_push($titles,$item['title']);
        return $titles;
    }

    public function renderGrid($patternFile, $options = null)
    {
        $yml = $this->getPattern($patternFile);
        $grid = $yml['grid'];
        $items = null;
        /*
         * check doble click event route
         */
        $dblclick = null;
        if(array_key_exists('dblclick',$grid))
        {
            $dblclick = $grid['dblclick'];
        }
        //--------------------------------------------------

        $queryBuilder = $this->em->createQueryBuilder('qur');
        $q = $queryBuilder->select('t');
        $q = $q->from($grid['entity'],'t');
        if(array_key_exists('parameters',$grid))
        {
            foreach ($grid['parameters'] as $key=>$param)
            {
                $validParam = $param;
                if($param == 'thisRoll')
                    $validParam = $this->userMgr->GetThisRollInfo()->getId();
                elseif ($param == 'thisUser')
                    $validParam = $this->userMgr->GetThisUserInfo()->getId();
                $q = $q->andWhere('t.' .$key . '=:' . $key);
                $q = $q->setParameter($key,$validParam);
                if(array_key_exists('orderBy',$grid))
                {
                    $ord = explode(':', $grid['orderBy']);
                    $q = $q->orderBy('t.' . $ord[0], $ord[1]);
                }
            }
        }

        $q = $queryBuilder->getQuery();
        $items = $q->getResult();
        $countAll = count($items);

        if($grid['isMultiPage'] == 'TRUE') {
            $qMultiPage = $q;
            $qMultiPage = $qMultiPage->setFirstResult(0);
            $qMultiPage = $qMultiPage->setMaxResults($grid['multiPage']['itemPerPage']);
            //perpare for mutlipage support
            $items = $qMultiPage->getResult();

        }

        $cols = [];
        foreach ($grid['items'] as $key=>$it)
        {
            array_push($cols,$key);

            if($it['type']=='join')
            {
                foreach ($items as $item)
                {
                    $opt = explode(':',$it['options']);
                    $getMethodName = 'get' . ucfirst($opt[2]);
                    $getItemMethodName = 'get' . ucfirst($key);
                    $setMethodName = 'set' . $key;
                    $res = $this->em->getRepository($opt[0] . ':' . $opt[1])->find($item->$getItemMethodName());
                    $item->$setMethodName($res->$getMethodName());

                }
            }
            elseif($it['type']=='jdate')
            {
                foreach ($items as $item)
                {
                    $setMethodName = 'set' . $key;
                    $getItemMethodName = 'get' . ucfirst($key);
                    $item->$setMethodName($this->jdate->jdate($it['options'],$item->$getItemMethodName()));

                }
            }

        }

        if($grid['isMultiPage'] == 'TRUE') {
            return $this->twig->render('Grid/standard-multipage.html.twig', [
                    'titles' => $this->getTitles($yml),
                    'items' => $items,
                    'cols' => $cols,
                    'grid' => $grid,
                    'dblclick'=>$dblclick,
                    'countAll'=>$countAll,
                    'patternName'=>$patternFile,
                    'perPage'=>$grid['multiPage']['itemPerPage']
                ]
            );
        }
        return $this->twig->render('Grid/standard.html.twig', [
                'titles' => $this->getTitles($yml),
                'items' => $items,
                'cols' => $cols,
                'grid' => $grid,
                'dblclick'=>$dblclick
            ]
        );
    }

    public function getPageItems($patternFile,$page)
    {
        $grid = $this->getPattern($patternFile);

        $items = $this->entityMgr->getByPage($grid['grid']['entity'],$page,$grid['grid']['multiPage']['itemPerPage']);

        $dblclick = null;
        if(array_key_exists('dblclick',$grid['grid']))
        {
            $dblclick = $grid['grid']['dblclick'];
        }
        //--------------------------------------------------

        $queryBuilder = $this->em->createQueryBuilder('qur');
        $q = $queryBuilder->select('t');
        $q = $q->from($grid['grid']['entity'],'t');
        if(array_key_exists('parameters',$grid['grid']))
        {
            foreach ($grid['grid']['parameters'] as $key=>$param)
            {
                $validParam = $param;
                if($param == 'thisRoll')
                    $validParam = $this->userMgr->GetThisRollInfo()->getId();
                elseif ($param == 'thisUser')
                    $validParam = $this->userMgr->GetThisUserInfo()->getId();
                $q = $q->andWhere('t.' .$key . '=:' . $key);
                $q = $q->setParameter($key,$validParam);
                if(array_key_exists('orderBy',$grid))
                {
                    $ord = explode(':', $grid['orderBy']);
                    $q = $q->orderBy('t.' . $ord[0], $ord[1]);
                }
            }
        }

        $q = $q->setMaxResults($grid['grid']['multiPage']['itemPerPage']);
        $q = $q->setFirstResult($grid['grid']['multiPage']['itemPerPage'] * ($page -1) );
        $q = $queryBuilder->getQuery();
        $items = $q->getResult();
        $countAll = count($items);

        $cols = [];
        foreach ($grid['grid']['items'] as $key=>$it)
        {
            array_push($cols,$key);

            if($it['type']=='join')
            {
                foreach ($items as $item)
                {
                    $opt = explode(':',$it['options']);
                    $getMethodName = 'get' . ucfirst($opt[2]);
                    $getItemMethodName = 'get' . ucfirst($key);
                    $setMethodName = 'set' . $key;
                    $res = $this->em->getRepository($opt[0] . ':' . $opt[1])->find($item->$getItemMethodName());
                    $item->$setMethodName($res->$getMethodName());

                }
            }
            elseif($it['type']=='jdate')
            {
                foreach ($items as $item)
                {
                    $setMethodName = 'set' . $key;
                    $getItemMethodName = 'get' . ucfirst($key);
                    $item->$setMethodName($this->jdate->jdate($it['options'],$item->$getItemMethodName()));

                }
            }

        }
        return $this->twig->render('Grid/ajaxLoad.html.twig',
            [
                'pageNumber'=>$page,
                'items' => $items,
                'grid' => $grid,
                'cols'=>$cols,
                'dblclick'=>$dblclick,
                'countAll'=>$countAll,
                'patternName'=>$patternFile,
                'perPage'=>$grid['grid']['multiPage']['itemPerPage']
            ]
        );
    }
}