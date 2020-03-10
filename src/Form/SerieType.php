<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Series;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('startday',DateType::class)
            ->add('endday',DateType::class)
            ->add('affiche',FileType::class,['attr'=>['class'=>'form-control-file']])
            ->add('nbsaison',IntegerType::class,['attr'=>['class'=>'form-control']])
            ->add('categorie',EntityType::class,['attr'=>['class'=>'form-control'],'class'=> Categories::class,'choice_label' => 'name'])
            ->add('submit',SubmitType::class,['attr'=>['class'=>'btn btn-primary']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Series::class,
        ]);
    }
}
