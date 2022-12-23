<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\User;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnnonceType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($this->security->getUser());
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ'
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Titre invalide !'
                    ])
                    ],
                'attr' => ['placeholder' => 'Titre de l\'annonce'],
                'label' => 'Titre',
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Description invalide !'
                    ])
                    ],
                'attr' => ['placeholder' => 'Description de l\'annonce'],
            ])
            ->add('price', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez remplir ce champ'
                    ]),
                    ],
                'attr' => ['placeholder' => 'Prix'],
            ])
            // ->add('created_at', HiddenType::class, [
            //     'data' => new DateTime()
            // ])
            // ->add('updated_at')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'title'])
            // ->add('AnnonceByUser', HiddenType::class, [
            //     'attr' => [
            //         'class' => User::class,
            //         'data' => $this->security->getUser()->__toString()
            //         ]
            // ])
            ->add('submit', SubmitType::class,[
                'attr' => ['class' => 'btn btn-success ']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
