<?php

namespace Atrapalo\PHPTools\Tests\Parser;

use Atrapalo\PHPTools\Parser\PHPDocClass;
use PHPUnit\Framework\TestCase;

class PHPDocTest extends TestCase
{
    /** @var PHPDocClass */
    private $parser;

    protected function setUp()
    {
        $this->parser = new PHPDocClass();
    }

    /**
     * @test
     * @expectedException \ReflectionException
     * @expectedExceptionMessage  Class NonExistClass does not exist
     */
    public function staticMethodsNonExistClass()
    {
        $this->parser->staticMethods('NonExistClass');
    }

    /**
     * @test
     */
    public function staticMethodsEmptyClass()
    {
        $methods = $this->parser->staticMethods(EmptyClass::class);

        $this->assertCount(0, $methods);
    }

    /**
     * @test
     * @expectedException \ReflectionException
     * @expectedExceptionMessage  Class NonExistClass does not exist
     */
    public function methodsNonExistClass()
    {
        $this->parser->methods('NonExistClass');
    }

    /**
     * @test
     */
    public function methodsEmptyClass()
    {
        $methods = $this->parser->methods(EmptyClass::class);

        $this->assertCount(0, $methods);
    }

    /**
     * @test
     */
    public function staticMethods()
    {
        $expectedStaticMethods = $this->expectedStaticMethods();
        $methods = $this->parser->staticMethods(ClassFixture::class);

        $this->assertSameSize($expectedStaticMethods, $methods);

        foreach ($methods as $key => $method) {
            $expectedMethod = $expectedStaticMethods[$key];

            $this->assertTrue($method->isStatic());
            $this->assertSame($expectedMethod[0], $method->return());
            $this->assertSame($expectedMethod[1], $method->name());
            $this->assertCount($expectedMethod[2], $method->params());
            $this->assertSame($expectedMethod[3], $method->description());
        }
    }

    /**
     * @test
     */
    public function methods()
    {
        $expectedStaticMethods = $this->expectedMethods();
        $methods = $this->parser->methods(ClassFixture::class);

        $this->assertSameSize($expectedStaticMethods, $methods);

        foreach ($methods as $key => $method) {
            $expectedMethod = $expectedStaticMethods[$key];

            $this->assertFalse($method->isStatic());
            $this->assertSame($expectedMethod[0], $method->return());
            $this->assertSame($expectedMethod[1], $method->name());
            $this->assertCount($expectedMethod[2], $method->params());
            $this->assertSame($expectedMethod[3], $method->description());
        }
    }

    /**
     * @return array
     */
    private function expectedStaticMethods(): array
    {
        return [
            ['', 'staticReturnUnknown', 0, ''],
            ['bool', 'staticReturnBool', 0, ''],
            ['boolean', 'staticReturnBoolean', 0, ''],
            ['int', 'staticReturnInt', 0, ''],
            ['integer', 'staticReturnInteger', 0, ''],
            ['float', 'staticReturnFloat', 0, ''],
            ['array', 'staticReturnArray', 0, ''],
            ['mixed', 'staticReturnFixed', 0, ''],
            ['\stdClass', 'staticReturnStdClass', 0, ''],
            ['\Exception', 'staticReturnException', 0, ''],
            ['$this', 'staticReturnThis', 0, ''],
            ['ClassFixture', 'staticReturnClassFixture', 0, ''],
            ['', 'staticReturnUnknownWithParam', 1, ''],
            ['', 'staticReturnUnknownWithParams', 3, ''],
            ['', 'staticReturnUnknownWithParamsJoined', 3, ''],
            ['', 'staticReturnUnknownWithParamTyped', 1, ''],
            ['', 'staticReturnUnknownWithParamsTyped', 3, ''],
            ['', 'staticReturnUnknownWithParamsTypedJoined', 3, ''],
            ['', 'staticReturnUnknownWithParamsTypedJoinedAll', 3, ''],
            ['int', 'staticReturnIntWithParam', 1, 'This method is staticReturnIntWithParam($param)'],
            ['int', 'staticReturnIntWithParams', 3, ''],
            ['int', 'staticReturnIntWithParamsJoined', 3, ''],
            ['int', 'staticReturnIntWithParamTyped', 1, ''],
            ['int', 'staticReturnIntWithParamsTyped', 3, ''],
            ['int', 'staticReturnIntWithParamsTypedJoined', 3, ''],
            ['int', 'staticReturnIntWithParamsTypedJoinedAll', 3, ''],
            ['int', 'staticReturnIntWithParamsTypedJoinedAllAndDesc', 3, 'This method is staticReturnIntWithParamsTypedJoinedAll(int$param,float$param2,ClassFixture$param3)']
        ];
    }

    /**
     * @return array
     */
    private function expectedMethods(): array
    {
        return [
            ['', 'returnUnknown', 0, ''],
            ['bool', 'returnBool', 0, ''],
            ['boolean', 'returnBoolean', 0, ''],
            ['int', 'returnInt', 0, ''],
            ['integer', 'returnInteger', 0, ''],
            ['float', 'returnFloat', 0, ''],
            ['array', 'returnArray', 0, ''],
            ['mixed', 'returnFixed', 0, ''],
            ['\stdClass', 'returnStdClass', 0, ''],
            ['\Exception', 'returnException', 0, ''],
            ['$this', 'returnThis', 0, ''],
            ['ClassFixture', 'returnClassFixture', 0, ''],
            ['', 'returnUnknownWithParam', 1, ''],
            ['', 'returnUnknownWithParams', 3, ''],
            ['', 'returnUnknownWithParamsJoined', 3, ''],
            ['', 'returnUnknownWithParamTyped', 1, ''],
            ['', 'returnUnknownWithParamsTyped', 3, ''],
            ['', 'returnUnknownWithParamsTypedJoined', 3, ''],
            ['', 'returnUnknownWithParamsTypedJoinedAll', 3, ''],
            ['bool', 'returnBoolWithParam', 1, ''],
            ['bool', 'returnBoolWithParams', 3, ''],
            ['bool', 'returnBoolWithParamsJoined', 3, ''],
            ['bool', 'returnBoolWithParamTyped', 1, ''],
            ['bool', 'returnBoolWithParamsTyped', 3, ''],
            ['bool', 'returnBoolWithParamsTypedJoined', 3, ''],
            ['bool', 'returnBoolWithParamsTypedJoinedAll', 3, '']
        ];
    }
}
