# UF_Breadcrumb
The breadcrumb services provider for Userfrosting 4.

## Install
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