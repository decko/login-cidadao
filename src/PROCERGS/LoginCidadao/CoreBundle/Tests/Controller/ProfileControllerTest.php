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

        // Criando usuario
        $username = 'usertest';
        $email = 'test@mail.com';
        $password = 'userpass';
        $this->configureUser($username, $email, $password);

        // Efetuando login
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->filter('form[name=login_form_type]')->form();
        $form['login_form_type[username]'] = $username;
        $form['login_form_type[password]'] = $password;

        // Enviando conta para login e redirecionar para dashboard
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
    public function testEditProfile()
    {
        $crawler = $this->client->request('GET', '/profile/edit');
        //$this->assertRegExp('/\/profile\/edit$/', $this->client->getResponse()->headers->get('location'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $form = $crawler->filter('form[name=fos_user_profile_form]')->form();
        $form['fos_user_profile_form[firstName]'] = 'User';
        $form['fos_user_profile_form[surname]'] = 'Test';
        $form['fos_user_profile_form[birthdate]'] = '01/01/1981';
        $form['fos_user_profile_form[nationality]'] = 36;   // BRAZIL
        $form['fos_user_profile_form[placeOfBirth][country]'] = 36; //BRAZIL
        $form['fos_user_profile_form[placeOfBirth][state_text]'] = 'Distrito Federal';  // DISTRITO FEDERAL
        $form['fos_user_profile_form[placeOfBirth][city_text]'] = 'Brasília';   // BRASILIA

        // Salvando dados
        $crawler = $this->client->submit($form);
        //print_r($this->client->getResponse());

        // Verificando definicao de perfil
        $userUpdated = $this->userManager->findUserByEmail('test@mail.com');
        print_r($userUpdated);
        $this->assertEquals('User', $userUpdated->getFirstName());
        $this->assertEquals('Test', $userUpdated->getSurname());


    }
    # TODO: Inserir dados do servidor publico
    #
    private function configureUser($username, $email, $password)
    {
        $kernel = static::createKernel();
        $this->repo = $kernel->boot();
        $this->repo = $kernel->getContainer();

        $this->userManager = $this->repo->get('fos_user.user_manager');


        $this->user = $this->userManager->createUser();
        $this->user->setEmail($email);
        $this->user->setUsername($username);
        //$this->user->setFirstName($username);
        $this->user->setMobile('(61) 9999-9999');
        $this->user->setPlainPassword($password);
        $this->user->setEnabled(1);

        $this->userManager->updateUser($this->user);
    }
}
