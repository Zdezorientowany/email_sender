<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailControllerTest extends WebTestCase
{
    public function testSendEmail()
    {
        $client = static::createClient();

        $client->enableProfiler();

        $client->request('POST', '/send-email', [
            'subject' => 'Test Subject',
            'message' => 'Test Message',
            'categories' => ['Users'],
        ]);

        $this->assertResponseStatusCodeSame(302);

        $emailCollector = $client->getProfile()->getCollector('mailer');
        $messages = $emailCollector->getEvents()->getMessages();

        $this->assertCount(10, $messages);
        $this->assertSame('Test Subject', $messages[0]->getSubject());
    }
}
