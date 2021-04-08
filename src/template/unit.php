<?php
/**
 * @var string $unitTestClassName
 * @var string $class
 * @var array $methods
 */
echo "<?php";
?>


Class <?= $unitTestClassName ?> extends \Codeception\Test\Unit
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

    public function test<?=$unitTestClassName?>(): void
    {

        $reflection = new ReflectionClass(<?=$class?>::class);
        $mock = $this->getMockBuilder(<?=$class?>::class)->getMockForAbstractClass();

<?php
foreach ($methods as $method) {
    /** @var $method ReflectionMethod */
    if ($method->class === $class && $method->getName() !== "__construct"){
        ?>
        self::assertTrue($reflection->hasMethod('<?=$method->getName()?>'));
        <?php
        if (!$method->isStatic())
        switch ((string)$method->getReturnType()){
            case "string":
                echo 'self::assertIsString($mock->'.$method->getName().'());';
                break;
          ?>


                <?php
        }
        echo "\n\n";
        ?>
<?php
    }
}

?>
    }
}


