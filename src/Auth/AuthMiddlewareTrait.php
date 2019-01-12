<?php

namespace H4MSK1\Auth;

trait AuthMiddlewareTrait
{
    public function onlyAuth(\Psr\Container\ContainerInterface $di, array $options = [])
    {
        $session = $di->get('session');
        $request = $di->get('request');

        if ($session->has('user') && ! is_null($session->get('user'))) {
            return;
        }

        if (array_key_exists('except', $options)) {
            foreach ($options['except'] as $route) {
                if ($this->isRouteMatched($request, $route)) {
                    return;
                }
            }
        } else if (array_key_exists('only', $options)) {
            foreach ($options['only'] as $route) {
                if ($this->isRouteMatched($request, $route)) {
                    return $di->get('response')->redirect('user/login')->send();
                }
            }
        } else if (! $session->has('user') || is_null($session->get('user'))) {
            if (! $this->isRouteMatched($request, 'user/login')) {
                return $di->get('response')->redirect('user/login')->send();
            }
        }
    }

    private function isRouteMatched($request, $expected)
    {
        $route = $request->getRoute();

        // test route e.g /user/id/{param}
        if (strpos($expected, '/{param}') !== false) {
            $expected = explode('/{param}', $expected)[0];
            $parts = explode('/', $route);
            unset($parts[count($parts) - 1]);
            $route = join('/', $parts);
        }

        return $route === $expected;
    }
}
