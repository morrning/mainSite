<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 20/05/2018
 * Time: 09:42 AM
 */
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form as Form;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form as FormOpt;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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

class formMgr
{

    protected $em;
    protected $formBuilder;
    protected $AppFolder;
    protected $userMgr;
    // We need to inject this variables later.
    public function __construct(EntityManagerInterface $entityManager,\Symfony\Component\Form\FormFactoryInterface $formFactory, userMgr $userMgr)
    {
        $this->em = $entityManager;

        $this->AppFolder = realpath(__DIR__.'/../');
        $this->formBuilder = $formFactory;
        $this->userMgr = $userMgr;
    }

    public function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function getPattern($EntityPattern)
    {
        return Yaml::parse(file_get_contents($this->AppFolder . '/EntityPattern/' . $EntityPattern));

    }

    public function renderForm($EntityPattern,$FormType = 'normal' ,$staticParams=[],$entity=null,$prefixFormName='')
    {
        $YamlForm = $this->getPattern($EntityPattern);
        $form = $this->formBuilder->createNamedBuilder($prefixFormName . 'form');
        if($FormType == 'normal')
        {
            foreach($YamlForm['items'] as $key=>$item)
            {
                $required = true;
                if(array_key_exists('required',$item))
                    $required = $item['required'];

                if($item['type'] == 'TextType')
                {
                    if(array_key_exists($key,$staticParams))
                        $form->add($key, TextType::class,array('required'=>$required,'data'=>$staticParams[$key], 'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                    else
                        $form->add($key, TextType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif($item['type'] == 'AutocompleteType')
                {
                    $form->add($key, Type\AutocompleteType::class ,array('label'=>$item['title'],'required'=>true,'attr'=>array('class' => 'input-sm','pattern'=>$item['pattern'])));
                }
                elseif($item['type'] == 'UserlistType')
                {
                    $form->add($key, Type\UserlistType::class,array('class'=>Entity\SysRoll::class,'choice_label'=>'rollName','choice_value'=>'id', 'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif($item['type'] == 'ToggleType')
                {
                    $form->add($key, Type\ToggleType::class,array());
                }
                elseif($item['type'] == 'UsernameType')
                {
                    $form->add($key, Type\UsernameType::class,array('class'=>Entity\SysUser::class,'choice_label'=>'fullName','choice_value'=>'id', 'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif($item['type'] == 'MoneyType')
                {
                    $form->add($key, MoneyType::class,array('grouping'=>true,'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif($item['type'] == 'PasswordType')
                {
                    $form->add($key, PasswordType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'NumberType')
                {
                    if(array_key_exists($key,$staticParams))
                        $form->add($key, NumberType::class,array('required'=>$required,'data'=>$staticParams[$key],'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                    else
                        $form->add($key, NumberType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'NumbermaskType')
                {
                    $options =array(
                        'required'=>$required,
                        'label'=>$item['title'],
                        'attr'=>array(
                            'class' => 'input-sm',
                            'maxValue' => $item['max-value'],
                            'minValue' => $item['min-value'],
                            'label' => $item['label']
                        )
                    );
                    if(array_key_exists('default',$item))
                        $options['data'] = $item['default'];
                    $form->add($key, Type\NumbermaskType::class,$options);
                }
                elseif ($item['type'] == 'JdateType')
                {
                    $form->add($key, Type\JdateType::class,array('required'=>$required,'label'=>$item['title']));
                }
                elseif ($item['type'] == 'CKEditorType')
                {
                    $form->add($key, CKEditorType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'FileboxType')
                {
                    $form->add($key, Type\FileboxType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'TextareaType')
                {
                    if(array_key_exists($key,$staticParams))
                        $form->add($key, TextareaType::class,array('required'=>$required,'data'=>$staticParams[$key],'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                    else
                        $form->add($key, TextareaType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'HiddenType')
                {
                    $form->add($key, HiddenType::class,array('data'=>$staticParams[$key],'attr'=>array('class' => 'input-sm')));
                }
                elseif ($item['type'] == 'ThisTime')
                {
                    $form->add($key, HiddenType::class,array('data'=>time()));
                }
                elseif ($item['type'] == 'ThisRoll')
                {
                    $form->add($key, HiddenType::class,array('data'=>$this->userMgr->GetThisRollInfo()->getId()));
                }
                elseif ($item['type'] == 'choiceType.entity')
                {
                    $colItems = $this->em->getRepository($item['entity'])->findAll();
                    $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$colItems,'choice_label'=>$item['colTitle'],'choice_value'=>$item['colValue']]);

                }
                elseif ($item['type'] == 'choiceType.integer')
                {
                    $col = [];
                    for($i=$item['startValue'];$i<= $item['endValue'];$i++)
                    {
                        array_push($col,$i);
                    }
                    $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$col]);

                }
                elseif ($item['type'] == 'ChoiceType.Array')
                {
                    $items = explode(',',$item['values']);
                    $orgiItems =[];
                    foreach ($items as $it)
                    {
                        $orgiItems[$it]=$it;
                    }
                    $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$orgiItems]);

                }
            }
        }
        $form->add('save', SubmitType::class, array('label' => 'ثبت','attr'=>array('class' => 'btn-md btn-primary')));
        return $form->getForm();
    }

    public function addForm($pattern,$form)
    {
        $YamlForm = $this->getPattern($pattern);

        $entityAdr = explode(':',$YamlForm['entity']['name']);

        $entityStr = '\\App\\Entity\\' . $entityAdr[1];
        $entity = new $entityStr();
        foreach($YamlForm['items'] as $key=>$item)
        {
            $setMethodStr = 'set' . ucfirst($key);
            if($item['type'] == 'UserlistType')
            {
                $entity->$setMethodStr($form->get($key)->getData()->getId());
            }
            else
            {
                $entity->$setMethodStr($form->get($key)->getData());

            }
        }

        $this->em->persist($entity);
        $this->em->flush();
        return $entity->getId();
    }

    public function renderFormForUpdate($EntityPattern ,$entityName, $id)
    {
        $YamlForm = $this->getPattern($EntityPattern);
        $form = $this->formBuilder->createNamedBuilder('formBuilder');
        $entity = $this->em->createQueryBuilder('r')
            ->select('r')
            ->from($entityName, 'r')
            ->Where('r.id = :id')
            ->setParameter('id',  $id)
            ->getQuery()
            ->getArrayResult()[0];

        foreach($YamlForm['items'] as $key=>$item)
        {
            $required = true;
            if(array_key_exists('required',$item))
                $required = $item['required'];

            if($item['type'] == 'TextType')
            {
                $form->add($key, TextType::class,array('required'=>$required,'data'=>$entity[$key], 'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif($item['type'] == 'UserlistType')
            {
                $form->add($key, Type\UserlistType::class,array('class'=>Entity\SysRoll::class,'choice_label'=>'rollName','choice_value'=>'id', 'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif($item['type'] == 'UsernameType')
            {
                $form->add($key, Type\UsernameType::class,array('class'=>Entity\SysUser::class,'choice_label'=>'fullName','choice_value'=>'id', 'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif($item['type'] == 'MoneyType')
            {
                $form->add($key, MoneyType::class,array('data'=>$entity[$key], 'required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif($item['type'] == 'PasswordType')
            {
                $form->add($key, PasswordType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif ($item['type'] == 'NumberType')
            {
                $form->add($key, NumberType::class,array('required'=>$required,'data'=>$entity[$key],'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif ($item['type'] == 'JdateType')
            {
                $form->add($key, Type\JdateType::class,array('required'=>$required,'label'=>$item['title']));
            }
            elseif ($item['type'] == 'CKEditorType')
            {
                $form->add($key, CKEditorType::class,array('required'=>$required,'data'=>$entity[$key],'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif ($item['type'] == 'FileboxType')
            {
                $form->add($key, Type\FileboxType::class,array('required'=>$required,'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));
            }
            elseif ($item['type'] == 'TextareaType')
            {
                $form->add($key, TextareaType::class,array('required'=>$required,'data'=>$entity[$key],'label'=>$item['title'],'attr'=>array('class' => 'input-sm')));

            }
            elseif ($item['type'] == 'HiddenType')
            {
                $form->add($key, HiddenType::class,array('data'=>$entity[$key],'attr'=>array('class' => 'input-sm')));
            }
            elseif ($item['type'] == 'ThisTime')
            {
                $form->add($key, HiddenType::class,array('data'=>time()));
            }
            elseif ($item['type'] == 'ThisRoll')
            {
                $form->add($key, HiddenType::class,array('data'=>$this->userMgr->GetThisRollInfo()->getId()));
            }
            elseif ($item['type'] == 'choiceType.entity')
            {
                $colItems = $this->em->getRepository($item['entity'])->findAll();
                $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$colItems,'choice_label'=>$item['colTitle'],'choice_value'=>$item['colValue']]);

            }
            elseif ($item['type'] == 'choiceType.integer')
            {
                $col = [];
                for($i=$item['startValue'];$i<= $item['endValue'];$i++)
                {
                    array_push($col,$i);
                }
                $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$col]);

            }
            elseif ($item['type'] == 'ChoiceType.Array')
            {
                $items = explode(',',$item['values']);
                $orgiItems =[];
                foreach ($items as $it)
                {
                    $orgiItems[$it]=$it;
                }
                $form->add($key,ChoiceType::class,['label'=>$item['title'],'choices'=>$orgiItems]);

            }
        }
        $form->add('save', SubmitType::class, array('label' => 'ثبت','attr'=>array('class' => 'btn-md btn-primary')));
        return $form->getForm();

    }
}