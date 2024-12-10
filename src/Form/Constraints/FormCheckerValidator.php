<?php

declare(strict_types=1);

namespace Libdevo\FormShieldBundle\Form\Constraints;

use Libdevo\FormShieldBundle\Event\FormCheckInvalid;
use LibertJeremy\Symfony\Helpers\Traits\EventDispatcherAwareTrait;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class FormCheckerValidator extends ConstraintValidator
{
    use EventDispatcherAwareTrait;

    public const string VIOLATION_INVALID = 'form_shield.form_checker.invalid';

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof FormChecker) {
            throw new UnexpectedTypeException($constraint, FormChecker::class);
        }

        if (empty($value)) {
            return;
        }

        $this
            ->eventDispatcher
            ->dispatch(
                (new FormCheckInvalid())
                    ->setValue($value)
            );

        $this
            ->context
            ->buildViolation(self::VIOLATION_INVALID)
            ->addViolation();
    }

    private function isInvalid(?string $value): bool
    {
        return
            !empty($value)
            || \strlen($value) > 0;
    }
}
