<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotInGroupnamesValidator extends ConstraintValidator
{
		public function validate($value, Constraint $constraint)
    {
        if (array_key_exists($value, $constraint->groupnames)) {
            $this->context->buildViolation($constraint->groupnamesMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}