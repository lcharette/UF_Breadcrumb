<?php

namespace UserFrosting\Sprinkle\Breadcrumb;

use Interop\Container\ContainerInterface;

/**
 * The Breadcrumbs class, which manage the breadcrumbs in the Application
 *
 * @package Breadcrumbs
 * @author Louis Charette
 * @link http://www.userfrosting.com/
 */
class BreadcrumbManager {

    /**
     * @var items[] An array of item in the breadcrumbs list.
     */
    protected $items = [];

     /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $ci;

    /**
     * Create a new Breadcrumbs object.
     *
     */
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
    }

	/**
     * Add an item at the end of the breadcrumbs list.
	 *
	 * @access public
	 * @param string $name (default: "")
	 * @param string $uri (default: "")
	 * @param bool $active (default: true)
	 * @return $this
	 */
	public function add($name = "", $uri = "", $active = true){

        // Make sure we have a $name setup. Route could be optional
		if ($name == "") {
    		return $this;
		}

		//Add the item to the array
		$this->items[] = $this->prepareItem($name, $uri, $active);

		// Return object for chainability
		return $this;
	}

	/**
     * Prepend an item at the beginning of the breadcrumbs list.
	 *
	 * @access public
	 * @param string $name (default: "")
	 * @param string $uri (default: "")
	 * @param bool $active (default: true)
	 * @return $this
	 */
	public function prepend($name = "", $uri = "", $active = true){

        // Make sure we have a $name setup. Route could be optional
		if ($name == "") {
    		return $this;
		}

		//Add the item to the array
		array_unshift($this->items, $this->prepareItem($name, $uri, $active));

		// Return object for chainability
		return $this;
	}


	/**
	 * get function.
	 * Get all the items in the breadcrumbs list. Also set the `first` and `last` flags
	 * for all items
	 *
	 * @access public
	 * @return Array the Breadcrumbs object list
	 */
	public function get() {

    	$items = $this->items;

    	// Add the site title at the beginning. Do it on $items, because we don't
    	// want to permanantly add it to the object, same as the `first` and `last` later
    	// We can't use `prepend` too since it requires `$this->items`
    	// TODO: Add site setting to enabled this or not
	    array_unshift($items, $this->prepareItem($this->ci->config['site.title'], "/"));

		// Before returning the item, we need to add a flash to the first and last one
        foreach ($items as $i => $value) {
            $items[$i] = array_merge($value, [
                'first' => ($i == 0) ? true : false,
                'last' => ($i == count($items)) ? true : false
            ]);
        }

		return $items;
	}

    /**
     * prepareItem function.
     * Apply translation and create the route for both `add` and `prepend` functions
     *
     * @access private
     * @param mixed $name
     * @param mixed $uri
     * @param mixed $active
     * @return Array Item object
     */
    private function prepareItem($name, $uri, $active) {

        // If $name is an array, we passed it as name / argument for the translation function
		if (is_array($name) && !empty($name)) {
    		$args = (isset($name[1])) ? $name[1] : [];
    		$n = $this->ci->translator->translate($name[0], $args);
		} else {
    		$n = $this->ci->translator->translate($name);
        }

		// If $uri is an array, we reconstruct the route
        if (is_array($uri) && !empty($uri)) {
            $args = (isset($uri[1])) ? $uri[1] : [];
            $uri = $this->ci->router->pathFor($uri[0], $args);
        }

        // Return the item object
        return [
			"title" => $n,
			"uri" => $uri,
			"active" => $active
		];
    }
}