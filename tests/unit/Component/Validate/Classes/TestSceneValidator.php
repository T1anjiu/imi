<?php

namespace Imi\Test\Component\Validate\Classes;

use Imi\Validate\Annotation\Decimal;
use Imi\Validate\Annotation\Integer;
use Imi\Validate\Validator;

/**  
 * @Decimal(name="decimal", min=1, max=10, accuracy=2)  
 * Validates that the 'decimal' field is a decimal number with a minimum value of 1, a maximum value of 10, and a maximum accuracy of 2 decimal places.  
 *  
 * @Integer(name="int", min=0, max=100, message="The value {:value} must be an integer between {min} and {max} (inclusive).")  
 * Validates that the 'int' field is an integer with a minimum value of 0 and a maximum value of 100. If the value does not fall within this range, an error message will be generated using the provided template.  
 */  
class TestSceneValidator extends Validator  
{  
    /**  
     * Scene definitions.  
     *  
     * @var array|null  
     */  
    protected $scene = [  
        'a' => ['decimal'], // Scene 'a' includes only the 'decimal' field for validation.  
        'b' => ['int'],     // Scene 'b' includes only the 'int' field for validation.  
        'c' => ['decimal', 'int'], // Scene 'c' includes both the 'decimal' and 'int' fields for validation.  
    ];  
}
