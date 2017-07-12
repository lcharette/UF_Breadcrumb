# Breadcrumb Sprinkle for [UserFrosting 4](https://www.userfrosting.com)

Breadcrumb services provider for Sprinkle for [UserFrosting 4](https://www.userfrosting.com).

# Help and Contributing

If you need help using this sprinkle or found any bug, feels free to open an issue or submit a pull request. You can also find me on the [UserFrosting Chat](https://chat.userfrosting.com/) most of the time for direct support. 

<a href='https://ko-fi.com/A7052ICP' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://az743702.vo.msecnd.net/cdn/kofi4.png?v=0' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

# Installation
Edit UserFrosting `app/sprinkles.json` file and add the following to the `require` list : `"lcharette/uf_breadcrumb": "^2.0.0"`. Also add `Breadcrumb` to the `base` list. For example:

```
{
    "require": {
        "lcharette/uf_breadcrumb": "^2.0.0"
    },
    "base": [
        "core",
        "account",
        "admin",
        "Breadcrumb"
    ]
}
```

Run `composer update` then `php bakery bake` to install the sprinkle.

## Usage

Breadcrumbs hierarchy cannot be autodetected right now. You have to define your hierarchy manually in your controllers. To dynamically add breadcrumbs to the UI, simply use the `add` method of the `breadcrumb` service:

```
// add($name = "", $uri = "", $active = true)
$this->ci->breadcrumb->add("Item name", "path/");
```

Note that the item name can also be a translation key. Path can be optional if you don't want to provide a link with your breadcrumb.

You can also use the `prepend` method to add a new item to the beginning of the list:

```
//prepend($name = "", $uri = "", $active = true)
$this->ci->breadcrumb->prepend("Item name", "path/");
```

Note that the site index is automatically added to the beginning of the list, whether you use `prepend` or not.

You can also chain multiple methods :

```
$this->ci->breadcrumb->add("Projects", "projects/")->add("Project Foo", "projects/foo");
```

**If you don't add any custom breadcrumbs, it will fallback to the default UserFrosting behaviour.**

## Custom style

The default UserFrosting layouts and themes will pick up the breadcrumbs automatically. If your UserFrosting theme doesn't include breadcrumbs automatically, simply add this line to your twig files:

```
{% include 'navigation/breadcrumb.html.twig' with {page_title: block('page_title')} %}
```

If you want to edit the style of the breadcrumbs, simply copy the `templates/navigation/breadcrumb.html.twig` file in your own sprinkle and edit according to your styling. No custom assets are included with this sprinkle.

# Licence
By [Louis Charette](https://github.com/lcharette). Copyright (c) 2017, free to use in personal and commercial software as per the MIT license.