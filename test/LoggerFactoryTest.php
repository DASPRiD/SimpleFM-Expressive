<?php
declare(strict_types = 1);

namespace SoliantTest\SimpleFM\Expressive;

use Interop\Container\ContainerInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Log\LoggerInterface;
use Soliant\SimpleFM\Expressive\LoggerFactory;

final class LoggerFactoryTest extends TestCase
{
    public function testSuccessfulCreation()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->willReturn([
            'simplefm' => [
                'logger' => [
                    'path' => tempnam(sys_get_temp_dir(), 'log'),
                ],
            ],
        ]);

        $factory = new LoggerFactory();
        $this->assertInstanceOf(LoggerInterface::class, $factory($container->reveal()));
    }
}
