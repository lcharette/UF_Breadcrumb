<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests;

use InvalidArgumentException;
use Mockery as m;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Crumb;
use UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager;
use UserFrosting\Sprinkle\Core\Router;
use UserFrosting\Support\Repository\Repository;
use UserFrosting\Tests\TestCase;

/**
 * ManagerTest
 *
 * Perform test for UserFrosting\Sprinkle\Breadcrumb\Breadcrumb\Manager
 */
class ManagerTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }

    public function testConstructor(): void
    {
        $config = m::mock(Repository::class);
        $translator = m::mock(Translator::class);
        $router = m::mock(Router::class);

        $manager = new Manager($config, $translator, $router);
        $this->assertInstanceOf(Manager::class, $manager);

        $this->assertCount(0, $manager->getCrumbs());
        $this->assertSame([], $manager->generate(false));
    }

    /**
     * Test for support of older version of translator
     * @depends testConstructor
     */
    public function testConstructorOldVersion(): void
    {
        $config = m::mock(Repository::class);
        $translator = m::mock('\UserFrosting\I18n\MessageTranslator');
        $router = m::mock(Router::class);

        $manager = new Manager($config, $translator, $router);
        $this->assertInstanceOf(Manager::class, $manager);
    }

    /**
     * @depends testConstructor
     */
    public function testConstructorInvalidTranlator(): void
    {
        $config = m::mock(Repository::class);
        $translator = m::mock('\UserFrosting\I18n\FooTranslator');
        $router = m::mock(Router::class);

        $this->expectException(InvalidArgumentException::class);
        $manager = new Manager($config, $translator, $router);
    }

    /**
     * @depends testConstructor
     */
    public function testBasics(): void
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('offsetGet')->withArgs(['site.title'])->andReturn('My Site');

        $translator = m::mock(Translator::class);
        $translator->shouldReceive('translate')->withArgs(['My Site', []])->andReturn('My Site');

        $router = m::mock(Router::class);
        $router->shouldReceive('pathFor')->withArgs(['/', []])->andReturn('/');

        $manager = new Manager($config, $translator, $router);
        $this->assertInstanceOf(Manager::class, $manager);

        $this->assertCount(0, $manager->getCrumbs());
        $this->assertSame([
            [
                'title'  => 'My Site',
                'uri'    => '/',
                'active' => false,
            ],
        ], $manager->generate());
    }

    /**
     * @depends testBasics
     */
    public function testAddPrependCrumb(): void
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('offsetGet')->withArgs(['site.title'])->andReturn('My Site');

        $translator = m::mock(Translator::class);
        $translator->shouldReceive('translate')->withArgs(['My Site', []])->andReturn('My Site');
        $translator->shouldReceive('translate')->withArgs(['First Title', []])->andReturn('First Title');
        $translator->shouldReceive('translate')->withArgs(['Middle Title', []])->andReturn('Middle Title');
        $translator->shouldReceive('translate')->withArgs(['Last Title', ['foo' => 'bar']])->andReturn('Last Title');

        $router = m::mock(Router::class);
        $router->shouldReceive('pathFor')->withArgs(['/', []])->andReturn('/');
        $router->shouldReceive('pathFor')->withArgs(['Bar', []])->andReturn('/Bar');
        $router->shouldReceive('pathFor')->withArgs(['/Middle', []])->andReturn('/middle');
        $router->shouldReceive('pathFor')->withArgs(['/Foo', ['Bar' => 'Foo']])->andReturn('/Foo');

        $manager = new Manager($config, $translator, $router);

        $crumb = new Crumb();
        $crumb->setTitle('Last Title', ['foo' => 'bar'])
              ->setRoute('/Foo', ['Bar' => 'Foo'])
              ->setActive(true);

        $manager->addCrumb(new Crumb('Middle Title', '/Middle', false))
                ->addCrumb($crumb)
                ->prependCrumb(new Crumb('First Title', 'Bar', false));

        $this->assertCount(3, $manager->getCrumbs());
        $this->assertContainsOnlyInstancesOf(Crumb::class, $manager->getCrumbs());
        $this->assertSame([
            [
                'title'  => 'My Site',
                'uri'    => '/',
                'active' => false,
            ],
            [
                'title'  => 'First Title',
                'uri'    => '/Bar',
                'active' => false,
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/middle',
                'active' => false,
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
                'active' => true,
            ],
        ], $manager->generate());

        $this->assertSame([
            [
                'title'  => 'First Title',
                'uri'    => '/Bar',
                'active' => false,
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/middle',
                'active' => false,
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
                'active' => true,
            ],
        ], $manager->generate(false));
    }

    /**
     * @depends testAddPrependCrumb
     */
    public function testAddPrepend(): void
    {
        $config = m::mock(Repository::class);
        $config->shouldReceive('offsetGet')->withArgs(['site.title'])->andReturn('My Site');

        $translator = m::mock(Translator::class);
        $translator->shouldReceive('translate')->withArgs(['My Site', []])->andReturn('My Site');
        $translator->shouldReceive('translate')->withArgs(['First Title', []])->andReturn('First Title');
        $translator->shouldReceive('translate')->withArgs(['Middle Title', []])->andReturn('Middle Title');
        $translator->shouldReceive('translate')->withArgs(['Last Title', ['foo' => 'bar']])->andReturn('Last Title');

        $router = m::mock(Router::class);
        $router->shouldReceive('pathFor')->withArgs(['/', []])->andReturn('/');
        $router->shouldReceive('pathFor')->withArgs(['Bar', []])->andReturn('/Bar');
        $router->shouldReceive('pathFor')->withArgs(['/Middle', []])->andReturn('/middle');
        $router->shouldReceive('pathFor')->withArgs(['/Foo', ['Bar' => 'Foo']])->andReturn('/Foo');

        $manager = new Manager($config, $translator, $router);

        $manager->add('Middle Title', '/Middle', false)
                ->add(['Last Title', ['foo' => 'bar']], ['/Foo', ['Bar' => 'Foo']], true)
                ->prepend('First Title', 'Bar', false);

        $this->assertCount(3, $manager->getCrumbs());
        $this->assertContainsOnlyInstancesOf(Crumb::class, $manager->getCrumbs());
        $this->assertSame([
            [
                'title'  => 'My Site',
                'uri'    => '/',
                'active' => false,
            ],
            [
                'title'  => 'First Title',
                'uri'    => '/Bar',
                'active' => false,
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/middle',
                'active' => false,
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
                'active' => true,
            ],
        ], $manager->generate());
    }

    /**
     * @depends testAddPrepend
     */
    public function testWithInvalidTitle(): void
    {
        $config = m::mock(Repository::class);
        $translator = m::mock(Translator::class);
        $router = m::mock(Router::class);

        $manager = new Manager($config, $translator, $router);

        $this->expectException(InvalidArgumentException::class);
        $manager->add([], '/Middle', false);
    }

    /**
     * @depends testAddPrepend
     */
    public function testWithInvalidRoute(): void
    {
        $config = m::mock(Repository::class);
        $translator = m::mock(Translator::class);
        $router = m::mock(Router::class);

        $manager = new Manager($config, $translator, $router);

        $this->expectException(InvalidArgumentException::class);
        $manager->add('Title', [], false);
    }

    /**
     * Test service registration
     */
    public function testService(): void
    {
        $service = $this->ci->breadcrumb;
        $this->assertInstanceOf(Manager::class, $service);
    }
}
