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

        $email = "testing@test.com";
        $un = "test";
        $fn = "testin";
        $ln = "laster";
        $pwd = "passworD1";

        $this->user = $this->userManager->createUser();

        $this->user->setEmail($email);
        $this->user->setUsername($un);
        $this->user->setFirstName($fn);
        $this->user->setPlainPassword($pwd);

        // Persist the user to the database
        $this->userManager->updateUser($this->user);

        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->filter('form[name=login_form_type]')->form();

        // set some values
        $form['login_form_type[username]'] = $un;
        $form['login_form_type[password]'] = $pwd;

        // submit the form
        $crawler = $this->client->submit($form);
        print_r($this->client->getResponse());

        $this->client->followRedirects();
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
