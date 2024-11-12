<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginPageIsAccessible()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Assert the login page is loaded successfully
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion à l\'application');
    }

    public function testLoginWithValidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Submit the login form with valid credentials
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'user@example.com',  // Ensure this user exists in your test database
            'password' => 'correct_password',
        ]);

        $client->submit($form);

        // Assert the response is a redirect to the homepage
        $this->assertResponseRedirects('/');
        $client->followRedirect();

        // Assert the user is now logged in
        $this->assertSelectorTextContains('h1', 'Bienvenue');
    }

    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // Submit the login form with invalid credentials
        $form = $crawler->selectButton('Se connecter')->form([
            'email' => 'wrongemail@example.com',
            'password' => 'wrongpassword',
        ]);

        $client->submit($form);

        // Assert the response is a redirect to the login page (failed login)
        $this->assertResponseRedirects('/login');
        $client->followRedirect();

        // Assert an error message is displayed
        $this->assertSelectorExists('.alert-danger');
    }
}