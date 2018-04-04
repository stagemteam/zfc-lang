<?php

namespace Stagem\Visitor\View\Helper\Factory;

use Psr\Container\ContainerInterface;
use Stagem\Visitor\Service\VisitorService;
use Stagem\Visitor\View\Helper\VisitorHelper;

class VisitorHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $visitor = $container->get(VisitorService::class)->getCurrent();
        $helper = new VisitorHelper($visitor);

        return $helper;
    }
}