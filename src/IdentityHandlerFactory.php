<?php
declare(strict_types = 1);

namespace Soliant\SimpleFM\Expressive;

use Assert\Assertion;
use Interop\Container\ContainerInterface;
use Soliant\SimpleFM\Authentication\BlockCipherIdentityHandler;
use Soliant\SimpleFM\Authentication\IdentityHandlerInterface;
use Zend\Crypt\BlockCipher;

final class IdentityHandlerFactory
{
    public function __invoke(ContainerInterface $container) : IdentityHandlerInterface
    {
        $config = $container->get('config');
        Assertion::isArrayAccessible($config);
        Assertion::keyIsset($config, 'simplefm');

        $simpleFmConfig = $config['simplefm'];
        Assertion::isArrayAccessible($simpleFmConfig);
        Assertion::keyIsset($simpleFmConfig, 'identity_handler');

        $identityHandlerConfig = $simpleFmConfig['identity_handler'];
        Assertion::isArrayAccessible($identityHandlerConfig);

        Assertion::keyIsset($identityHandlerConfig, 'key');

        return new BlockCipherIdentityHandler(
            BlockCipher::factory('openssl', ['algo' => 'aes'])->setKey($identityHandlerConfig['key'])
        );
    }
}
