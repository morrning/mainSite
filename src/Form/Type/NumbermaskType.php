<?php
/**
 * Created by PhpStorm.
 * User: babak
 * Date: 19/06/2018
 * Time: 06:28 AM
 */

namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NumbermaskType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getName()
    {
        return 'Numbermask';
    }
}