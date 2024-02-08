<?php

namespace Imi\Test\Component\Tests;

use Imi\Bean\BeanFactory;
use Imi\Test\BaseTest;
use Imi\Test\Component\Enum\TestEnum;
use Imi\Test\Component\Validate\Classes\TestAutoConstructValidator;
use Imi\Test\Component\Validate\Classes\TestSceneAnnotationValidator;
use Imi\Test\Component\Validate\Classes\TestSceneValidator;
use Imi\Test\Component\Validate\Classes\TestValidator;

/**
 * @testdox Validator Annotation
 */
class ValidatorAnnotationTest extends BaseTest
{
    /**
     * @var \Imi\Test\Component\Validate\Classes\TestValidator
     */
    private $tester;

    /**
     * @var array
     */
    private $data;

    public function testValidatorAnnotation()
    {
        $this->tester = new TestValidator($this->data);
        $this->success();
        $this->compareFail();
        $this->decimalFail();
        $this->enumFail();
        $this->inFail();
        $this->intFail();
        $this->requiredFail();
        $this->numberFail();
        $this->textFail();
        $this->textCharFail();
        $this->validateValueFail();
        $this->regexFail();
        $this->optional();
    }

    public function testAutoConstructValidator()
    {
        $this->initData();
        $test = BeanFactory::newInstance(TestAutoConstructValidator::class, $this->data);

        // int fail
        $this->data['int'] = 1000;
        try
        {
            $test = BeanFactory::newInstance(TestAutoConstructValidator::class, $this->data);
            $this->assertTrue(false, 'Construct validate property fail');
        }
        catch (\Throwable $th)
        {
            $this->assertStringEndsWith('1000 does not meet the criteria of being greater than or equal to 0 and less than or equal to 100', $th->getMessage());
        }

        try
        {
            $test = new TestAutoConstructValidator();
            $this->assertTrue(false, 'Construct validate fail');
        }
        catch (\Throwable $th)
        {
        }
    }

    public function testMethodAutoValidate()
    {
        $this->initData();
        $test = BeanFactory::newInstance(TestAutoConstructValidator::class, $this->data);
        $this->assertEquals(1, $test->test(1));
        try
        {
            $test->test(-1);
            $this->assertTrue(false, 'Method validate fail');
        }
        catch (\Throwable $th)
        {
        }
    }

    private function initData()
    {
        $this->data = [
            'compare'       => -1,
            'decimal'       => 1.25,
            'enum'          => TestEnum::A,
            'in'            => 1,
            'int'           => 1,
            'required'      => '',
            'number'        => 1,
            'text'          => 'imiphp.com',
            'chars'         => 'imiphp.com',
            'validateValue' => -1,
            'optional'      => 1,
            'regex'         => 123,
        ];
    }

    private function success()
    {
        $this->initData();
        $result = $this->tester->validate();
        $this->assertTrue($result, $this->tester->getMessage() ?: '');
    }

    private function compareFail()
    {
        $this->initData();
        $this->data['compare'] = 1;
        $this->assertFalse($this->tester->validate());
    }

    private function decimalFail()
    {
        $this->initData();
        $this->data['decimal'] = 1.222;
        $this->assertFalse($this->tester->validate());

        $this->data['decimal'] = 0;
        $this->assertFalse($this->tester->validate());

        $this->data['decimal'] = 11;
        $this->assertFalse($this->tester->validate());
    }

    private function enumFail()
    {
        $this->initData();
        $this->data['enum'] = 100;
        $this->assertFalse($this->tester->validate());
    }

    private function inFail()
    {
        $this->initData();
        $this->data['in'] = 100;
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('100 is not present in the list', $this->tester->getMessage());
    }

    private function intFail()
    {
        $this->initData();
        $this->data['int'] = -1;
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('-1 is not within the range of 0 to 100', $this->tester->getMessage());

        $this->data['int'] = 'a';
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('a is not within the range of 0 to 100', $this->tester->getMessage());
    }

    private function requiredFail()
    {
        $this->initData();
        unset($this->data['required']);
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('required is a mandatory parameter', $this->tester->getMessage());
    }

    private function numberFail()
    {
        $this->initData();
        $this->data['number'] = 1.234;
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The numeric value must be greater than or equal to 0.01 and less than or equal to 999.99, with a maximum of 2 decimal places. The current value is 1.234', $this->tester->getMessage());

        $this->data['number'] = 0;
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The numeric value must be greater than or equal to 0.01 and less than or equal to 999.99, with a maximum of 2 decimal places. However, the current value is 0, which does not meet the minimum requirement of 0.01', $this->tester->getMessage());
    }

    private function textFail()
    {
        $this->initData();
        $this->data['text'] = '';
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The length of the text parameter must be >=6 && <=12', $this->tester->getMessage());

        $this->data['text'] = '1234567890123';
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The length of the text parameter must be >=6 && <=12', $this->tester->getMessage());
    }

    private function textCharFail()
    {
        $this->initData();

        $this->data['chars'] = 'This can be passed';
        $this->assertTrue($this->tester->validate());

        $this->data['chars'] = 'Test failed';
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The length of the chars parameter must be >=6 && <=12', $this->tester->getMessage());

        $this->data['chars'] = 'Test does not pass';
        $this->assertFalse($this->tester->validate());
        $this->assertEquals('The length of the chars parameter must be >=6 && <=12', $this->tester->getMessage());
    }

    private function validateValueFail()
    {
        $this->initData();
        $this->data['validateValue'] = '1';
        $this->assertFalse($this->tester->validate());
    }

    private function regexFail()
    {
        $this->initData();
        $this->data['regex'] = 'a1';
        $this->assertFalse($this->tester->validate());
    }

    private function optional()
    {
        $this->initData();
        $this->data['optional'] = -1;
        $this->assertFalse($this->tester->validate());

        unset($this->data['optional']);
        $this->assertTrue($this->tester->validate());
    }

    public function testScene()
    {
        $data = [
            'decimal' => 1.1,
        ];
        $validator = new TestSceneValidator($data);
        $this->assertTrue($validator->setCurrentScene('a')->validate());

        $data = [
            'decimal' => 'a',
        ];
        $validator = new TestSceneValidator($data);
        $this->assertFalse($validator->setCurrentScene('a')->validate());

        $data = [
            'int' => 1,
        ];
        $validator = new TestSceneValidator($data);
        $this->assertTrue($validator->setCurrentScene('b')->validate());

        $data = [
            'int' => 'b',
        ];
        $validator = new TestSceneValidator($data);
        $this->assertFalse($validator->setCurrentScene('b')->validate());

        $data = [
            'decimal' => 1.1,
            'int'     => 1,
        ];
        $validator = new TestSceneValidator($data);
        $this->assertTrue($validator->setCurrentScene('b')->validate());

        $data = [
            'decimal' => 'a',
            'int'     => 'b',
        ];
        $validator = new TestSceneValidator($data);
        $this->assertFalse($validator->setCurrentScene('b')->validate());

        // All
        $data = [
            'decimal' => 1.1,
            'int'     => 1,
        ];
        $validator = new TestSceneValidator($data);
        $this->assertTrue($validator->validate());

        $data = [
            'decimal' => 'a',
            'int'     => 'b',
        ];
        $validator = new TestSceneValidator($data);
        $this->assertFalse($validator->validate());
    }

    public function testSceneWithAnnotation()
    {
        $data = [
            'decimal' => 1.1,
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertTrue($validator->setCurrentScene('a')->validate());

        $data = [
            'decimal' => 'a',
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertFalse($validator->setCurrentScene('a')->validate());

        $data = [
            'int' => 1,
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertTrue($validator->setCurrentScene('b')->validate());

        $data = [
            'int' => 'b',
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertFalse($validator->setCurrentScene('b')->validate());

        $data = [
            'decimal' => 1.1,
            'int'     => 1,
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertTrue($validator->setCurrentScene('b')->validate());

        $data = [
            'decimal' => 'a',
            'int'     => 'b',
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertFalse($validator->setCurrentScene('b')->validate());

        // All
        $data = [
            'decimal' => 1.1,
            'int'     => 1,
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertTrue($validator->validate());

        $data = [
            'decimal' => 'a',
            'int'     => 'b',
        ];
        $validator = new TestSceneAnnotationValidator($data);
        $this->assertFalse($validator->validate());
    }
}
