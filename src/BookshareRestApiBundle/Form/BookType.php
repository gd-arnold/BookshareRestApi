<?php

namespace BookshareRestApiBundle\Form;

use BookshareRestApiBundle\Entity\Subcategory;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', TextType::class)
            ->add('description', TextType::class)
            ->add('publisher', TextType::class)
            ->add('datePublished', TextType::class)
            ->add('imageURL', TextType::class)
            ->add('subcategory', Subcategory::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}
