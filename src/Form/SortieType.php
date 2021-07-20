<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Entity\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',

            ])
            ->add('duree')
            ->add('dateLimiteInscription', DateType::class,[
                'html5' => true,
                'widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax')
            ->add('infosSortie')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'placeholder' => 'Campus',
                'label' => 'Campus',
                'mapped' => false,
            ])
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Etat',
                'label' => 'Etat',
                'mapped' => false,])
            ->add('participants')
            ->add('participant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
