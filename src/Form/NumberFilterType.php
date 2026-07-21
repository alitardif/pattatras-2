<?php

namespace App\Form;

use App\Service\PattatrasService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

final class NumberFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('number', IntegerType::class, [
            'label' => 'Nombre à afficher',
            'required' => true,
            'attr' => [
                'min' => PattatrasService::DEFAULT_START,
                'max' => PattatrasService::DEFAULT_END,
                'placeholder' => sprintf(
                    'Entre %d et %d',
                    PattatrasService::DEFAULT_START,
                    PattatrasService::DEFAULT_END,
                ),
                'inputmode' => 'numeric',
            ],
            'constraints' => [
                new NotBlank(message: 'Veuillez saisir un nombre.'),
                new Range(
                    min: PattatrasService::DEFAULT_START,
                    max: PattatrasService::DEFAULT_END,
                    notInRangeMessage: 'Le nombre doit être compris entre {{ min }} et {{ max }}.',
                ),
            ],
            'invalid_message' => 'Veuillez saisir un nombre entier valide.',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
