<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminProductController extends WebTestCase
{
    public function testAddNewProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/new-product', [], [], [
            "Authorization" => "Basic YWRtaW46YWRtaW4="
        ]);

        $form = $crawler->filter('#form_save')->form();

        $form['title'] = 'Name of product';
        $form['price'] = 99.99;
        $form['description'] = "Description about product";

        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }
}