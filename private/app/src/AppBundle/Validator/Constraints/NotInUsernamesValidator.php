<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotInUsernamesValidator extends ConstraintValidator
{
		public function validate($value, Constraint $constraint)
    {
        if (array_key_exists($value, $constraint->usernames)) {
            $this->context->buildViolation($constraint->usernamesMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}