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

namespace K8s\HttpGuzzle;

use GuzzleHttp\Client;
use K8s\Core\Contract\ContextConfigInterface;
use K8s\Core\Contract\HttpClientFactoryInterface;
use Psr\Http\Client\ClientInterface;

class ClientFactory implements HttpClientFactoryInterface
{
    /**
     * @var array
     */
    private $defaults;

    /**
     * @param array<string, mixed> $defaults Any additional default options wanted for the Symfony HttpClient.
     */
    public function __construct(array $defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * @inheritDoc
     */
    public function makeClient(ContextConfigInterface $fullContext, bool $isStreaming): ClientInterface
    {
        $options = $this->defaults;
        $options['timeout'] = $isStreaming ? -1 : ($options['timeout'] ?? 15);
        $options['base_uri'] = $fullContext->getServer();

        if ($fullContext->getClientCertificate()) {
            $options['cert'] = $fullContext->getClientCertificate();
            $options['ssl_key'] = $fullContext->getClientKey();
        }

        if ($fullContext->getServerCertificateAuthority()) {
            $options['verify'] = $fullContext->getServerCertificateAuthority();
        }

        return new Client($options);
    }
}
