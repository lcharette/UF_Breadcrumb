<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Integration;

use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager;
use UserFrosting\Sprinkle\Core\Tests\withController;
use UserFrosting\Tests\TestCase;
use UserFrosting\UniformResourceLocator\ResourceLocator;

/**
 * Perform functional test with a stub controller.
 */
class BreadcrumbTest extends TestCase
{
    use withController;

    public function setUp(): void
    {
        parent::setUp();

        /** @var ResourceLocator */
        $locator = $this->ci->locator;

        // Register test location for test templates
        $locator->registerLocation('test', __DIR__);

        // Register a temp stream for asertion results
        $locator->registerSharedStream('results', '', __DIR__ . '/results');

        // Force site title
        $this->ci->config['site.title'] = 'FOOBAR SITE';
    }

    public function testBreadcrumbsSimple(): void
    {
        $result = $this->ci->view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile('results://simple.txt', $result);
    }

    public function testBreadcrumbsCustom(): void
    {
        /** @var Manager */
        $breadcrumb = $this->ci->breadcrumb;
        $breadcrumb->add('Foo');

        $result = $this->ci->view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile('results://custom.txt', $result);
    }

    public function testBreadcrumbsMultiple(): void
    {
        /** @var Manager */
        $breadcrumb = $this->ci->breadcrumb;
        $breadcrumb->add('Bar', '/Bar')
                   ->add('Foo')
                   ->add('Blah', '/blah')
                   ->add('Foo Bar');

        $result = $this->ci->view->fetch('breadcrumbs.html.twig');
        $this->assertXmlStringEqualsXmlFile('results://multiple.txt', $result);
    }
}
