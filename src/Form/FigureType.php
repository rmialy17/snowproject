<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Figure;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\Form\FileUploadError;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,  [ 
            'mapped' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un titre',
                ]),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Le titre de la figure doit comporter {{ limit }} caractères minimum.',
                    // max length allowed by Symfony for security reasons
                    'max' => 10,
                    'maxMessage' => 'Le titre de la figure ne peut contenir plus de {{ limit }} caractères.', 
                ])]])
            // ->add('description')
            ->add('description', TextType::class,  [ 
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'La description doit comporter {{ limit }} caractères minimum.',
                        // max length allowed by Symfony for security reasons
                        'max' => 300,
                        'maxMessage' => 'Le description ne peut contenir plus de {{ limit }} caractères.', 
                    ])]])
            ->add('imagetop_upload',FileType::class, array('required' => false),[
                 'label' => 'Ajouter/Modifier image principale'
                   ])
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'libelle'])
             // On ajoute le champ "images" dans le formulaire
            // Il n'est pas lié à la base de données (mapped à false)
            ->add('images', FileType::class, [
                'label' => 'Ajouter des images :',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            // ->add('videos')
            ->add('video', UrlType::class, [
                // ->add('video', TextType::class, [  
                'label' => 'Ajouter des videos :',
                'mapped' => false,
                'required' => false,
                'constraints' => [new Regex([
                    'pattern'=> '/^https?:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+$/',
                    'message' => 'Veuillez ajouter une URL valide. Exemple: https://www.youtube.com/embed/GCL7BuX_SqY'])]])
    ;
            }  
       
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
