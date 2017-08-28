// apiproduct_listing.js
// ------------------------------------------------------------------
//
// To support client-side filtering and search on the set of API Products.
// Depends on filter.js, from https://github.com/jiren/filter.js
//
// created: Wed Nov  9 10:16:26 2016
// last saved: <2016-November-30 14:49:46>

jQuery(document).ready(function($) {
  var prodFilter = null;
  if (typeof rawProducts !== 'undefined') {
    var $catContent = $('#block-apiproduct-listing-product-listing-block div.content');
    // insert the search box:
    $catContent
      .append('<div class="sidebar_list">' +
              '<h3>Search</h3>' +
              '<input type="text" id="search_box" class="searchbox" placeholder="Type here &hellip;" />' +
              '</div>');

    // replace the anchors for each of the categories, with checkboxes
    $catContent.find('.item-list ul.apiproduct-category-list li')
      .each(function(ix, elt) {
        var $this = $(elt);
        var categoryName = $this.find('a').text().trim();
        var catLow = categoryName.toLowerCase();
        var uniqueId = catLow + '-' + ix;
        var className = (catLow == 'all')? 'category-all': 'category-name';
        $this.html('<input id="'+ uniqueId+'" value="'+categoryName+'" class="'+className+'" type="checkbox">' +
                   '<span class="category-name">' + categoryName + '</span>');
      });

    // turn on all the checkboxes we just added
    $catContent.find(':checkbox.category-name').prop('checked', true);
    $catContent.find(':checkbox.category-all').prop('checked', true);

    // event handlers to insure the all/some state of the checkboxes is consistent
    var $allCheck = $("#all-0");
    var $otherChecks = $catContent.find(':checkbox.category-name').not('#all-0');
    $allCheck.change(function(){
      $otherChecks.prop('checked', this.checked);
      // if (prodFilter) { prodFilter.filter(); } // in case there are no categories at all.
      // if(this.checked){ $otherChecks.prop('checked', true); }
      // else {
      //   $otherChecks.prop('checked', false);
      // }
    });
    $otherChecks.click(function () {
      if ($(this).is(":checked")){
        var allChecked = true;
        $otherChecks.each(function(){ if(!this.checked) { allChecked = false; } }) ;
        if(allChecked) {
          $allCheck.prop("checked", true);
        }
      }
      else {
        $allCheck.prop("checked", false);
      }
    });

    // This sets up the filter, on search box and category checkboxes
    prodFilter = FilterJS(rawProducts, "#apiproduct_filtered_list", {
      template: '#prod_template',
      criterias:[
        {field: 'categories', ele: 'ul.apiproduct-category-list :checkbox'}
      ],
      search: { ele: '#search_box' }
    });
  }
});
