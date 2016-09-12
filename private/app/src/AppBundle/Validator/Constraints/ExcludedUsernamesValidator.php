<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExcludedUsernamesValidator extends ConstraintValidator
{
		public function validate($value, Constraint $constraint)
    {
        if (in_array($value, $constraint->excludedUsernames)) {
            $this->context->buildViolation($constraint->excludedUsernamesMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}