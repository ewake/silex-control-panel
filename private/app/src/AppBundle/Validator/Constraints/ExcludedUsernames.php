<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExcludedUsernames extends Constraint
{
    public $excludedUsernamesMessage = 'Username "%string%" not allowed.';
    public $excludedUsernames;
    
    public function __construct($options = null)
    {
    	if (null !== $options && !is_array($options)) {
    		$options = array(
    				'excludedUsernames' => $options,
    		);
    	}
    	
    	parent::__construct($options);
    }
}