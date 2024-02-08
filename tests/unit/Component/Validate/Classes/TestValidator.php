<?php

namespace Imi\Test\Component\Validate\Classes;

use Imi\Validate\Annotation\Compare;
use Imi\Validate\Annotation\Decimal;
use Imi\Validate\Annotation\InEnum;
use Imi\Validate\Annotation\InList;
use Imi\Validate\Annotation\Integer;
use Imi\Validate\Annotation\Number;
use Imi\Validate\Annotation\Regex;
use Imi\Validate\Annotation\Required;
use Imi\Validate\Annotation\Text;
use Imi\Validate\Annotation\ValidateValue;
use Imi\Validate\Validator;

/**  
 * @Compare(name="compare", operation="<", value=0)  
 * Validates that the 'compare' field is less than 0.  
 *  
 * @Decimal(name="decimal", min=1, max=10, accuracy=2)  
 * Validates that the 'decimal' field is a decimal number between 1 and 10 (inclusive), with a maximum of 2 decimal places.  
 *  
 * @InEnum(name="enum", enum=\Imi\Test\Component\Enum\TestEnum::class)  
 * Validates that the 'enum' field is a valid value from the \Imi\Test\Component\Enum\TestEnum enumeration.  
 *  
 * @InList(name="in", list={1, 2, 3}, message="{:value} is not in the list")  
 * Validates that the 'in' field contains a value from the list [1, 2, 3]. If not, the given message is displayed.  
 *  
 * @Integer(name="int", min=0, max=100, message="{:value} does not fall within the range of {min} to {max}")  
 * Validates that the 'int' field is an integer between 0 and 100 (inclusive). If not, the given message is displayed.  
 *  
 * @Required(name="required", message="{name} is a required parameter")  
 * Ensures that the 'required' field is provided and not empty. If missing, the given message is displayed.  
 *  
 * @Number(name="number", min=0.01, max=999.99, accuracy=2, message="The value must be greater than or equal to {min}, less than or equal to {max}, with a maximum of {accuracy} decimal places. The current value is {:value}")  
 * Validates that the 'number' field is a number within the specified range, with the given accuracy. If not, the given message is displayed.  
 *  
 * @Text(name="text", min=6, max=12, message="{name} length must be between {min} and {max}")  
 * Validates that the 'text' field is a string with a length between 6 and 12 (inclusive). If not, the given message is displayed.  
 *  
 * @Text(name="chars", char=true, min=6, max=12, message="{name} length must be between {min} and {max}")  
 * Validates that the 'chars' field is a string of characters with a length between 6 and 12 (inclusive). If not, the given message is displayed.  
 *  
 * @Compare(name="validateValue", value=@ValidateValue("{:data.compare}"), operation="==")  
 * Validates that the 'validateValue' field is equal to the value of ':data.compare'.  
 *  
 * @Integer(name="optional", min=0, max=100, message="{:value} does not fall within the range of {min} to {max}", optional=true)  
 * Optionally validates that the 'optional' field is an integer between 0 and 100 (inclusive). If not, the given message is displayed.  
 *  
 * @Regex(name="regex", pattern="/^\d+$/")  
 * Validates that the 'regex' field matches the regular expression '/^\d+$/', which ensures it contains only digits.  
 */
class TestValidator extends Validator
{
}
