<?php

namespace Imi\Test\Component\Validate\Classes;

use Imi\Validate\Annotation\Decimal;
use Imi\Validate\Annotation\Integer;
use Imi\Validate\Annotation\Scene;
use Imi\Validate\Validator;

/**  
 * @Decimal(name="decimal", min=1, max=10, accuracy=2)  
 * Validates that 'decimal' is a number between 1 and 10 (inclusive) with a maximum of 2 decimal places.  
 *   
 * @Integer(name="int", min=0, max=100, message="The value {:value} must be an integer between {min} and {max} (inclusive).")  
 * Validates that 'int' is an integer value between 0 and 100 (inclusive).  
 *   
 * @Scene(name="a", fields={"decimal"})  
 * Defines a validation scene 'a' that includes only the 'decimal' field.  
 *   
 * @Scene(name="b", fields={"int"})  
 * Defines a validation scene 'b' that includes only the 'int' field.  
 *   
 * @Scene(name="c", fields={"decimal", "int"})  
 * Defines a validation scene 'c' that includes both the 'decimal' and 'int' fields.  
 */
class TestSceneAnnotationValidator extends Validator
{
}
