<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ExcludedGroupnames extends Constraint
{
    public $excludedGroupnamesMessage = 'Group "%string%" not allowed.';
    public $excludedGroupnames;
    
    public function __construct($options = null)
    {
    	if (null !== $options && !is_array($options)) {
    		$options = array(
    				'excludedGroupnames' => $options,
    		);
    	}
    	
    	parent::__construct($options);
    }
}