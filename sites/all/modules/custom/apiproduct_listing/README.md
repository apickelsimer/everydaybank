# apiproduct_listing_ex

This is a custom drupal module for use within an Apigee Edge developer portal,
which displays the API Product list, organized by category. In other words, the API Product Catalog.

This module allows client-side (browser-side) search and filter of the API Product catalog.


## Using it

You need to do 2 things in order to use this module:

1. add the module to your Drupal into sites/all/modules/custom/apiproduct_listing

2. configure your API Products in Apigee Edge with custom attributes. 

For each API product to appear in the listing, Administrators should configure it as "public", and should also attach some custom attributeS:

| attribute name | description                                 | 
|:---------------|:--------------------------------------------|
| category       | comma-separated list of category names the product belongs to. Example: "Members, Loyalty" |
| ext_description| long-form description of the purpose of the API product, suitable for developers who might subscribe to the product. |
| doc_url        | a URL that links to the documentation for this API Product. It need not be a URL local to the developer portal, but it would be better.  You can use a relative URL here. | 
| image_url      | a URL for an image to display in the tile on the API Product listing page. With multiple images, it works best to make them all the same size, eg 232x148, or 232x200.  Can use a relative URL here.  If you do so, it should refer to an image which has been uploaded with a separate module or in some other way uploaded to the drupal devportal. | 



## Design

The orginal apiproduct_listing module emitted a templatized, themed HTML
page for the list of API Products, and used a drupal template for each
API Product. This worked just fine, but it didn't permit quick
client-side search and filtering.

This version of the module now uses a jQuery filtering plugin, [filter.js](https://github.com/jiren/filter.js), 
to support the client-side search and filter.

The module still uses the
[apiproduct-listing-apiproducts.tpl.php](templates/apiproduct-listing-apiproducts.tpl.php)
template for emitting the list. BUT, rather than emitting a straight
HTML page, instead what that template does is emit an empty placeholder
div, along with a \<script> tag containing a JS array representing the
set of available API Products and the categories.

The filter.js plugin then generates the HTML dynamically based on that Javascript array.

## Notes

* This module has never been tested outside of a Fazio-based devportal.
* Please raise bugs and pull requests

## Weird

No idea why, but when I modify the .css file, I get this warning in the
webpage served by Drupal:

```
The specified file temporary://fileIxb7Ez could not be copied, because
the destination directory is not properly configured. This may be caused
by a problem with file or directory permissions. More information is
available in the system log.
```

## License

This module is Copyright 2015, 2016 Apigee Corporation, 
and is licensed under the [Apache 2.0 source License](LICENSE).

