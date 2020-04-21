<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb\Tests\Unit;

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
        $translator->shouldReceive('translate')->withArgs(['My Site', []])->once()->andReturn('My Site');
        $translator->shouldReceive('translate')->withArgs(['First Title', []])->twice()->andReturn('First Title');
        $translator->shouldReceive('translate')->withArgs(['Middle Title', []])->twice()->andReturn('Middle Title');
        $translator->shouldReceive('translate')->withArgs(['Last Title', ['foo' => 'bar']])->twice()->andReturn('Last Title');

        $router = m::mock(Router::class);
        $router->shouldReceive('pathFor')->withArgs(['/', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['Bar', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['/Middle', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['Foo', ['Bar' => 'Foo']])->twice()->andReturn('/Foo');

        $manager = new Manager($config, $translator, $router);

        $crumb = new Crumb();
        $crumb->setTitle('Last Title', ['foo' => 'bar'])
              ->setRoute('Foo', ['Bar' => 'Foo']);

        $manager->addCrumb(new Crumb('Middle Title', '/Middle'))
                ->addCrumb($crumb)
                ->prependCrumb(new Crumb('First Title', 'Bar'));

        $this->assertCount(3, $manager->getCrumbs());
        $this->assertContainsOnlyInstancesOf(Crumb::class, $manager->getCrumbs());
        $this->assertSame([
            [
                'title'  => 'My Site',
                'uri'    => '/',
            ],
            [
                'title'  => 'First Title',
                'uri'    => 'Bar',
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/Middle',
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
            ],
        ], $manager->generate());

        $this->assertSame([
            [
                'title'  => 'First Title',
                'uri'    => 'Bar',
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/Middle',
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
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
        $translator->shouldReceive('translate')->withArgs(['My Site', []])->once()->andReturn('My Site');
        $translator->shouldReceive('translate')->withArgs(['First Title', []])->once()->andReturn('First Title');
        $translator->shouldReceive('translate')->withArgs(['Middle Title', []])->once()->andReturn('Middle Title');
        $translator->shouldReceive('translate')->withArgs(['Last Title', ['foo' => 'bar']])->once()->andReturn('Last Title');

        $router = m::mock(Router::class);
        $router->shouldReceive('pathFor')->withArgs(['/', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['Bar', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['/Middle', []])->never();
        $router->shouldReceive('pathFor')->withArgs(['Foo', ['Bar' => 'Foo']])->once()->andReturn('/Foo');

        $manager = new Manager($config, $translator, $router);

        $manager->add('Middle Title', '/Middle')
                ->add(['Last Title', ['foo' => 'bar']], ['Foo', ['Bar' => 'Foo']])
                ->prepend('First Title', 'Bar');

        $this->assertCount(3, $manager->getCrumbs());
        $this->assertContainsOnlyInstancesOf(Crumb::class, $manager->getCrumbs());
        $this->assertSame([
            [
                'title'  => 'My Site',
                'uri'    => '/',
            ],
            [
                'title'  => 'First Title',
                'uri'    => 'Bar',
            ],
            [
                'title'  => 'Middle Title',
                'uri'    => '/Middle',
            ],
            [
                'title'  => 'Last Title',
                'uri'    => '/Foo',
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
        $manager->add([], '/Middle');
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
        $manager->add('Title', []);
    }

    /**
     * Test service registration
     */
    public function testService(): void
    {
        /** @var Manager */
        $breadcrumb = $this->ci->breadcrumb;
        $this->assertInstanceOf(Manager::class, $breadcrumb);

        // Test with real life services
        $expected = [
            [
                'title'  => 'Foo',
                'uri'    => '/Bar',
            ],
        ];
        $breadcrumb->add('Foo', '/Bar');
        $this->assertSame($expected, $breadcrumb->generate(false));
    }
}
