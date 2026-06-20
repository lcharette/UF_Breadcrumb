<?php

/*
 * UserFrosting Breadcrumb Sprinkle
 *
 * @link      https://github.com/lcharette/UF_Breadcrumb
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_Breadcrumb/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\Breadcrumb;

use InvalidArgumentException;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/**
 * The Breadcrumbs class, which manage the breadcrumbs in the Application.
 */
class BreadcrumbManager
{
    /**
     * @var array<Crumb> An array of crumb in the breadcrumbs list.
     */
    protected $crumbs = [];

    public function __construct(
        protected Config $config,
        protected Translator $translator,
        protected RouteParserInterface $routeParser,
    ) {
    }

    /**
     * Add an crumb at the end of the breadcrumbs list.
     *
     * @param string|array<string|mixed> $title
     * @param string|array<string|mixed> $uri   (default: "")
     *
     * @return self
     */
    public function add($title, $uri = '')
    {
        $crumb = $this->newCrumb($title, $uri);
        $this->addCrumb($crumb);

        return $this;
    }

    /**
     * Add an crumb at the end of the breadcrumbs list.
     *
     * @param Crumb $crumb
     *
     * @return self
     */
    public function addCrumb(Crumb $crumb)
    {
        $this->crumbs[] = $crumb;

        return $this;
    }

    /**
     * Prepend an crumb at the beginning of the breadcrumbs list.
     *
     * @param string|array<string|mixed> $title
     * @param string|array<string|mixed> $uri   (default: "")
     *
     * @return self
     */
    public function prepend($title, $uri = '')
    {
        $crumb = $this->newCrumb($title, $uri);
        $this->prependCrumb($crumb);

        return $this;
    }

    /**
     * Prepend an crumb at the beginning of the breadcrumbs list.
     *
     * @param Crumb $crumb
     *
     * @return self
     */
    public function prependCrumb(Crumb $crumb)
    {
        array_unshift($this->crumbs, $crumb);

        return $this;
    }

    /**
     * Added a new Crumb instance.
     *
     * @param string|array<string|mixed> $title
     * @param string|array<string|mixed> $uri
     *
     * @return Crumb
     */
    protected function newCrumb($title, $uri = ''): Crumb
    {
        $crumb = new Crumb();

        // If $name is an array, we passed it as name / argument for the translation function
        if (is_string($title)) {
            $crumb->setTitle($title);
        } elseif (is_array($title) && !empty($title)) {
            $crumb->setTitle($title[0], (isset($title[1])) ? $title[1] : []);
        } else {
            throw new InvalidArgumentException('Title must be string or an array of [messagekey, placeholders].');
        }

        // If $uri is an array, we reconstruct the route
        if (is_string($uri)) {
            $crumb->setUri($uri);
        } elseif (is_array($uri) && !empty($uri)) {
            $args = (isset($uri[1])) ? $uri[1] : [];
            $crumb->setRoute($uri[0], $args);
        } else {
            throw new InvalidArgumentException('Uri must be string or an array of [routename, data].');
        }

        return $crumb;
    }

    /**
     * Get all the raw crumbs in the breadcrumbs list.
     *
     * @return array<Crumb> the Breadcrumbs object list
     */
    public function getCrumbs(): array
    {
        return $this->crumbs;
    }

    /**
     * Generate the array for the twig template.
     *
     * @param bool $addSiteTitle
     *
     * @return array<array<string,string|bool>>
     */
    public function generate(bool $addSiteTitle = true): array
    {
        $crumbs = $this->getCrumbs();

        if ($addSiteTitle) {
            array_unshift($crumbs, $this->getSiteTitle());
        }

        return array_map([$this, 'crumbToArray'], $crumbs);
    }

    /**
     * Return the site title crumb.
     *
     * @return Crumb
     */
    protected function getSiteTitle(): Crumb
    {
        return new Crumb($this->config['site.title'], '/');
    }

    /**
     * Convert crumb to array.
     *
     * @param Crumb $crumb
     *
     * @return array<string,string>
     */
    protected function crumbToArray(Crumb $crumb): array
    {
        $route = $crumb->getRoute();
        if (!is_string($route)) {
            list($name, $data) = $route;

            $route = $this->routeParser->urlFor($name, $data);
        }

        return [
            'title'  => $this->translator->translate($crumb->getTitle(), $crumb->getTitlePlaceholder()),
            'uri'    => $route,
        ];
    }
}
