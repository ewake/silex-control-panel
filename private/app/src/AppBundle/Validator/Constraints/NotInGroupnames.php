<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotInGroupnames extends Constraint
{
    public $groupnamesMessage = 'Group "%string%" already exists.';
    public $groupnames;
    
    public function __construct($options = null)
    {
    	if (null !== $options && !is_array($options)) {
    		$options = array(
    				'groupnames' => $options,
    		);
    	}
    	
    	parent::__construct($options);
    }
}