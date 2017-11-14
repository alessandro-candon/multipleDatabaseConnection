<?php
namespace Tests\Common\Fixtures;


use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $task = new Task();
            $task->setName('taskname '.$i);
            $task->setDescription('taskdescription'.$i);
            $manager->persist($task);
        }
        $manager->flush();
    }
}