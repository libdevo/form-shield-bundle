<?php

declare(strict_types=1);

namespace Libdevo\FormShieldBundle\Form;

use Libdevo\FormShieldBundle\Form\Constraints\FormChecker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormCheckerType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('constraints', [
            new FormChecker(),
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'core_form_checker';
    }
}
