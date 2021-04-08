<?php


namespace Vdme\CodeceptionGU;

use Codeception\Command\Shared\Config;
use Codeception\Command\Shared\FileSystem;
use Codeception\CustomCommandInterface;
use ReflectionMethod;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GenerateUnitForClass extends Command implements CustomCommandInterface
{
    use FileSystem;
    use Config;

    public function __construct(string $name = null)
    {

        parent::__construct($name);
        $this->addArgument('className', InputArgument::REQUIRED);
    }

    /**
     * returns the name of the command
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return "generate:ufc";
    }


    /**
     * Returns the description for the command.
     *
     * @return string The description for the command
     */
    public function getDescription(): string
    {
        return "Generates unit tests for class";
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getSuiteConfig('unit')['path'];

        if ($input->getArgument('className')) {
            $class = $input->getArgument('className');
            $match = [];

            if (class_exists($class) || interface_exists($class)){
                $match = [$class];
            }

            if (1 == count($match)) {
                $unitTestClassNameArr = explode('\\', $class);
                $unitTestClassName = end($unitTestClassNameArr)."Test";
                $generated = $this->render('unit',  $unitTestClassName, end($match));
                $this->createFile($path . DIRECTORY_SEPARATOR . $unitTestClassName . ".php", $generated, true);
            } else {
                $output->writeln('No match', 1);
            }

        }
        return 0;
    }

    private function render($template, $unitTestClassName, $class): string
    {

        $reflectionClass = new \ReflectionClass($class);

        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        ob_start();
        include __DIR__ . "/template/" . $template . ".php";
        $template = ob_get_clean();


        return $template;
    }


}