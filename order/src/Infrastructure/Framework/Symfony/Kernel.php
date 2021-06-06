<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getConfigDir() . '/{packages}/*.yaml');
        $container->import($this->getConfigDir() . '/{packages}/' . $this->environment . '/*.yaml');

        if (is_file($servicesYamlPath = $this->getConfigDir() . '/services.yaml')) {
            $container->import($servicesYamlPath);
            $container->import($this->getConfigDir() . '/{services}_' . $this->environment . '.yaml');
        } elseif (is_file($servicesPhpPath = $this->getConfigDir() . '/services.php')) {
            (require $servicesPhpPath)($container->withPath($servicesPhpPath), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getConfigDir() . '/{routes}/' . $this->environment . '/*.yaml');
        $routes->import($this->getConfigDir() . '/{routes}/*.yaml');

        if (is_file($routesYamlPath = $this->getConfigDir() . '/routes.yaml')) {
            $routes->import($routesYamlPath);
        } elseif (is_file($routesPhpPath = \dirname(__DIR__) . '/config/routes.php')) {
            (require $routesPhpPath)($routes->withPath($routesPhpPath), $this);
        }
    }

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }
}
