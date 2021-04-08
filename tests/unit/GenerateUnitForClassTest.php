<?php

Class GenerateUnitForClassTest extends \Codeception\Test\Unit
{
    /**
     * @var \CommonTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGenerateUnitForClassTest(): void
    {

        $reflection = new ReflectionClass(Vdme\CodeceptionGU\GenerateUnitForClass::class);
        $mock = $this->getMockBuilder(Vdme\CodeceptionGU\GenerateUnitForClass::class)->getMockForAbstractClass();

        self::assertTrue($reflection->hasMethod('getCommandName'));
        

        self::assertTrue($reflection->hasMethod('getDescription'));
        self::assertIsString($mock->getDescription());

    }
}


