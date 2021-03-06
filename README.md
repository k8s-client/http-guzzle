# k8s-http-guzzle

This library provides a Guzzle based HttpClient factory for the `k8s/client` library.

## General Use with the K8s library / Configuration Options

1. Install the library:

`composer require k8s/http-guzzle`

2. Construct the main client for `k8s/client` through the `K8sFactory`:

```php
use K8s\Client\K8sFactory;

# Load the client from the default KubeConfig
$k8s = (new K8sFactory())->loadFromKubeConfig();
```

Your new client will have all the HttpClient options needed pre-populated when used.
