<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PillboxApiTest extends KernelTestCase
{
    public function testPillboxApiConnection()
    {
        self::bootKernel();
        $client = self::$container->get(HttpClientInterface::class);

        $response = $client->request('GET', getenv('PILULIER_REMOTE_URL'));

        // Assert the API is accessible and responds with a 200 status code
        $this->assertSame(200, $response->getStatusCode());
    }
}