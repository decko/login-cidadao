<?php

namespace PROCERGS\LoginCidadao\CoreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfileControllerTest extends WebTestCase
{
    protected $client;
    protected $user;
    protected $userManager;

    public function setUp()
    {
        $kernel = static::createKernel();
        $this->repo = $kernel->boot();
        $this->repo = $kernel->getContainer();

        $this->userManager = $this->repo->get('fos_user.user_manager');

        $username = 'usertest';
        $email = 'test@mail.com';
        $password = 'userpass';

        $this->user = $this->userManager->createUser();
        $this->user->setEmail($email);
        $this->user->setUsername($username);
        $this->user->setFirstName('Test');
        $this->user->setMobile('(61) 9999-9999');
        $this->user->setPlainPassword($password);
        $this->user->setEnabled(1);

        // Persist the user to the database
        $this->userManager->updateUser($this->user);

        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->filter('form[name=login_form_type]')->form();

        // set some values
        $form['login_form_type[username]'] = $username;
        $form['login_form_type[password]'] = $password;

        // submit the form
        $crawler = $this->client->submit($form);
        $this->client->followRedirect();
    }

    public function tearDown()
    {
        $this->userManager->deleteUser($this->user);
    }

    public function testRedirectDashboard()
    {
        $this->assertRegExp('/\/dashboard$/', $this->client->getResponse()->headers->get('location'));
    }

    # TODO: Editar o perfil
    # TODO: Inserir dados do servidor publico
}
