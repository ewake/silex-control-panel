<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotInUsernames extends Constraint
{
    public $usernamesMessage = 'Username "%string%" already exists.';
    public $usernames;
    
    public function __construct($options = null)
    {
    	if (null !== $options && !is_array($options)) {
    		$options = array(
    				'usernames' => $options,
    		);
    	}
    	
    	parent::__construct($options);
    }
}