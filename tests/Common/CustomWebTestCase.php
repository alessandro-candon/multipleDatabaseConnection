<?php

namespace Tests\Common;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Tests\Common\Fixtures\Fixtures;

abstract class CustomWebTestCase extends WebTestCase
{

    public static function cleanDatabase()
    {
        static::bootKernel();
        $app = new Application(static::$kernel);
        $app->setAutoExit(false);
        $app->run(new ArrayInput([
            'command' => 'doctrine:schema:drop',
            '--force' => true,
            '--env' => 'test'
        ]), new ConsoleOutput());


        $app->run(new ArrayInput([
            'doctrine:schema:create',
            '--env' => 'test',]), new ConsoleOutput());
    }


    public static function loadFixtures()
    {
        static::bootKernel();
        $app = new Application(static::$kernel);
        $app->setAutoExit(false);
        self::cleanDatabase();
        $app->run(new ArrayInput([
            'doctrine:fixtures:load',
            '--env' => 'test',
            '--fixtures' => self::$kernel->getRootDir()."/../tests/Common/Fixtures/",
            '--append' => true
        ]), new ConsoleOutput());
    }
}