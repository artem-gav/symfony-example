<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminProductController extends WebTestCase
{
    public function testAddNewProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/new-product', [], [], [
            "HTTP_AUTHORIZATION" => "Basic YWRtaW46YWRtaW4="
        ]);

        $form = $crawler->selectButton('Create product')->form();

        $form['form[title]'] = 'Name of product';
        $form['form[price]'] = 99.99;
        $form['form[description]'] = "Description about product";

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }
}