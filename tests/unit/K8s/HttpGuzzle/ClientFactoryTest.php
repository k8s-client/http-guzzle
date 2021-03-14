<?php

/**
 * This file is part of the k8s/http-guzzle library.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace unit\K8s\HttpGuzzle;

use GuzzleHttp\Client;
use K8s\Core\Contract\ContextConfigInterface;
use K8s\HttpGuzzle\ClientFactory;

class ClientFactoryTest extends TestCase
{
    /**
     * @var ClientFactory
     */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();
        $this->subject = new ClientFactory();
    }

    public function testItCanMakeTheClient()
    {
        $fullContext = \Mockery::spy(ContextConfigInterface::class);
        $fullContext->shouldReceive([
            'getServerCertificate' => '/foo.ca',
            'getClientCertificate' => '/client.crt',
            'getClientKey' => '/client.key',
            'getServer' => 'https://foo.local:8443'
        ]);

        $result = $this->subject->makeClient($fullContext, false);
        $this->assertInstanceOf(Client::class, $result);
    }
}
