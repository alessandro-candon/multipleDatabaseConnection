<?php

namespace Tests\AppBundle\Controller;


use Tests\Common\CustomWebTestCase;

class TaskControllerTest extends CustomWebTestCase
{
    public static function setUpBeforeClass()
    {
        parent::loadFixtures();
    }

    public function test_get_all_task_controller()
    {
        $client = self::createClient();
        $client->request(
            'GET',
            "/tasks"
        );

        $json = '[{"id":1,"name":"taskname 0","description":"taskdescription0"},{"id":2,"name":"taskname 1","description":"taskdescription1"}]';

        $this->assertEquals($json, $client->getResponse()->getContent());

    }

    public function test_get_all_task_controller_database_not_exist_use_default_db()
    {
        $client = self::createClient();
        $client->request(
            'GET',
            "/database/databasenotexist"
        );
        $client->request(
            'GET',
            "/tasks"
        );
        $json = '[{"id":1,"name":"taskname 0","description":"taskdescription0"},{"id":2,"name":"taskname 1","description":"taskdescription1"}]';

        $this->assertEquals($json, $client->getResponse()->getContent());
    }
}