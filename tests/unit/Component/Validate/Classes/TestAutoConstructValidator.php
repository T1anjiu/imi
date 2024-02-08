<?php

namespace Imi\Test\Component\Validate\Classes;

use Imi\Util\LazyArrayObject;
use Imi\Validate\Annotation\AutoValidation;
use Imi\Validate\Annotation\Compare;
use Imi\Validate\Annotation\Decimal;
use Imi\Validate\Annotation\InEnum;
use Imi\Validate\Annotation\InList;
use Imi\Validate\Annotation\Integer;
use Imi\Validate\Annotation\Number;
use Imi\Validate\Annotation\Required;
use Imi\Validate\Annotation\Text;
use Imi\Validate\Annotation\ValidateValue;

/**  
 * @AutoValidation  
 *  
 * @Compare(name="compare", operation="<", value=0)  
 * Validates that the 'compare' value is less than 0.  
 *  
 * @Decimal(name="decimal", min=1, max=10, accuracy=2)  
 * Validates that 'decimal' is a number between 1 and 10 (inclusive) with a maximum of 2 decimal places.  
 *  
 * @InEnum(name="enum", enum=\Imi\Test\Component\Enum\TestEnum::class)  
 * Validates that 'enum' is a value from the \Imi\Test\Component\Enum\TestEnum enumeration.  
 *  
 * @InList(name="in", list={1, 2, 3}, message="The value {:value} is not in the list.")  
 * Validates that 'in' is one of the values in the list [1, 2, 3].  
 *  
 * @Required(name="required", message="The parameter {name} is required.")  
 * Validates that the 'required' parameter is present and not null or empty.  
 *  
 * @Number(name="number", min=0.01, max=999.99, accuracy=2, message="The number must be between {min} and {max}, with a maximum of {accuracy} decimal places. The current value is {:value}.")  
 * Validates that 'number' is a numeric value between 0.01 and 999.99 (inclusive) with a maximum of 2 decimal places.  
 *  
 * @Text(name="text", min=6, max=12, message="The length of the parameter {name} must be between {min} and {max}.")  
 * Validates that the length of 'text' is between 6 and 12 characters (inclusive).  
 *  
 * @Compare(name="validateValue", value=@ValidateValue("{:data.compare}"), operation="==")  
 * Validates that 'validateValue' is equal to the value of 'compare' from the data array.  
 */
class TestAutoConstructValidator extends LazyArrayObject  
{  
    /**  
     * @Integer(min=0, max=100, message="The value {:value} must be between {min} and {max} (inclusive).")  
     *  
     * @var int  
     */  
    public $int;  
  
    /**  
     * @AutoValidation  
     *  
     * @Integer(name="value", min=0, max=100, message="The value {:value} must be between {min} and {max} (inclusive).")  
     *  
     * @param int $value  
     *  
     * @return int  
     */  
    public function test(int $value)  
    {  
        return $value;  
    }  
}
