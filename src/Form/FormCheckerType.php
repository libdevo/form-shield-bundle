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
        $resolver->setDefault('required', false);
        $resolver->setDefault('mapped', false);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
