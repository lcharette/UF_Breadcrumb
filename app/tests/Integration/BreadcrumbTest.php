<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Integration;

use DI\Container;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Breadcrumb\BreadcrumbManager;
use UserFrosting\Sprinkle\Breadcrumb\Manager;
use UserFrosting\Sprinkle\Breadcrumb\Tests\BreadcrumbTestCase;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;
use UserFrosting\UniformResourceLocator\ResourceStream;

const RESULT_DIR = __DIR__ . "/results";

/**
 * Perform functional test with a stub controller.
 */
class BreadcrumbTest extends BreadcrumbTestCase
{
    protected Container $container;

    public function setUp(): void
    {
        parent::setUp();

        $locator = $this->ci->get(ResourceLocatorInterface::class);

        // Register test location for test templates
        $locator->addLocation(new ResourceLocation('test', __DIR__));

        $config = $this->ci->get(Config::class);

        $config['site.title'] = 'FOOBAR SITE';
    }

    public function testBreadcrumbsSimple(): void
    {
        $view = $this->ci->get(Twig::class);

        $result = $view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile(RESULT_DIR . '/simple.txt', $result);
    }

    public function testBreadcrumbsCustom(): void
    {
        $breadcrumb = $this->ci->get(BreadcrumbManager::class);
        $breadcrumb->add('Foo');

        $view = $this->ci->get(Twig::class);
        $result = $view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile(RESULT_DIR . '/custom.txt', $result);
    }

    public function testBreadcrumbsMultiple(): void
    {
        $breadcrumb = $this->ci->get(BreadcrumbManager::class);
        $breadcrumb->add('Bar', '/Bar')
                   ->add('Foo')
                   ->add('Blah', '/blah')
                   ->add('Foo Bar');

        $view = $this->ci->get(Twig::class);
        $result = $view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile(RESULT_DIR . '/multiple.txt', $result);
    }
}
