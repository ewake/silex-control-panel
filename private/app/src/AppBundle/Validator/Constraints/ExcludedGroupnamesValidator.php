<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExcludedGroupnamesValidator extends ConstraintValidator
{
		public function validate($value, Constraint $constraint)
    {
        if (in_array($value, $constraint->excludedGroupnames)) {
            $this->context->buildViolation($constraint->excludedGroupnamesMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}