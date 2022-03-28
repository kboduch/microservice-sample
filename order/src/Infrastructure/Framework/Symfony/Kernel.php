<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getConfigDir() . '/{packages}/*.yaml');
        $container->import($this->getConfigDir() . '/{packages}/' . $this->environment . '/*.yaml');
        $servicesYamlPath = $this->getConfigDir() . '/services.yaml';
        $servicesPhpPath = $this->getConfigDir() . '/services.php';

        if (is_file($servicesYamlPath)) {
            $container->import($servicesYamlPath);
            $container->import($this->getConfigDir() . '/{services}_' . $this->environment . '.yaml');
        } elseif (is_file($servicesPhpPath)) {
            (require $servicesPhpPath)($container->withPath($servicesPhpPath), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getConfigDir() . '/{routes}/' . $this->environment . '/*.yaml');
        $routes->import($this->getConfigDir() . '/{routes}/*.yaml');
        $routesYamlPath = $this->getConfigDir() . '/routes.yaml';
        $routesPhpPath = \dirname(__DIR__) . '/config/routes.php';

        if (is_file($routesYamlPath)) {
            $routes->import($routesYamlPath);
        } elseif (is_file($routesPhpPath)) {
            (require $routesPhpPath)($routes->withPath($routesPhpPath), $this);
        }
    }

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }
}
