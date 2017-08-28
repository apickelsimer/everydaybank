/**Global availables
 *$settings:
 *$slides:
 *$layers:
 *currentSlideIndex:
 *currentLayerIndex:
 **/
if ($slides == null) $slides = new Array();
//$slides.staticLayers = $slides.staticLayers || [];
if ($settings == null) $settings = {};
var defaultSettings = {
  delay: 9000,
  startheight: 400,
  startwidth: 960,
  fullWidth: 'on',
  fullScreen: 'off',
  navigationType: 'bullet',
  navigationArrows: 'verticalcentered',
  navigationHAlign: 'center',
  navigationVAlign: 'bottom',
  navigationStyle: 'square',
  timer: 'bottom'
};
var defaultSlide = {
  title: 'New Slide',
  data_masterspeed: 500,
  layers: [],
  removed: 0,
  data_transition: 'fade'
};
var defaultLayer = {
  index: 10,
  title: '',
  type: 'text',
  text: 'New Text Layer',
  image: '',
  fid: '',
  video: '',
  top: 0,
  left: 0,
  data_speed: 500,
  incomingclasses: 'randomrotate',
  outgoingclasses: '',
  data_start: 1000,
  data_end: 0,
  data_easing: 'easeOutExpo',
  data_endeasing: '',
  removed: 0,
  video_width: 600,
  video_height: 400,
  video_volume: 'yes',
  video_autoplay: 1,
  video_fullwidth: 0,
  width: 200,
  height: 100,
  custom_css: ''
}
var $firsttime = true;
var $contenttypes = {
  text: 0,
  image: 1,
  video: 2
};
(function ($) {
  function addGoogleFont(font, style) {
    font = font.replace(/\s/g, "+") + ':' + style;
    $('head').append("<link href='https://fonts.googleapis.com/css?family=" + font + "' rel='stylesheet' type='text/css'>");
  }
  var adjustPos = function ($element, top, left, voffset, hoffset) {
    var slider_design = $('#slidedesign'),
      _left = 0,
      _top = 0;
    voffset = voffset || 0;
    hoffset = hoffset || 0;
    voffset = parseInt(voffset);
    hoffset = parseInt(hoffset);
    if (left === 'left') {
      _left = 0 + hoffset;
    } else if (left === 'center') {
      _left = (slider_design.width() - $element.width()) / 2 + hoffset;
    } else if (left === 'right') {
      _left = slider_design.width() - $element.width() + hoffset;
    } else {
      _left = parseInt(left) + hoffset;
    }
    if (top === 'top') {
      _top = 0 + voffset;
    } else if (top === 'center') {
      _top = (slider_design.height() - $element.height()) / 2 + voffset;
    } else if (top === 'bottom') {
      _top = slider_design.height() - $element.height() + voffset;
    } else {
      _top = parseInt(top) + voffset;
    }
    $element.css({
      left: _left + 'px',
      top: _top + 'px'
    });
  };
  setInterval(function(){
    $($slides[currentSlideIndex].layers).each(function(layerIndex){
      var element = $('#'+currentSlideIndex+'-'+layerIndex);
      adjustPos(element,this.top,this.left,this.voffset,this.hoffset);
    });
  },500);
  var stripHTML = function (dirtyString) {
    return dirtyString.replace(/(<([^>]+)>)/ig, '');
    var container = document.createElement('div');
    var text = document.createTextNode(dirtyString);
    container.appendChild(text);
    return $(container).text(); // innerHTML will be a xss safe string
  }
  $(document).ready(function () {
    if ($slides.length == 0) {
      $('#dexp_layerslider_main').hide(0);
    }
    init();
    $('#slideslist').sortable({
      update: function (event, ui) {
        $('#slideslist').find('li').each(function (index) {
          var sindex = $(this).attr('index');
          $slides[sindex].index = index;
          $slides.sort(DexpCompare);
          init();
        })
      }
    });
    $('#addslide').click(function (e) {
      e.preventDefault();
      duplicateSlide(defaultSlide);
    })
    $('#addLayer').click(function (e) {
      e.preventDefault();
      duplicateLayer(defaultLayer);
      return false;
    })
    $('#save').click(function () {
      saveLayerSlider(false);
    })
    $('#save2').click(function () {
      saveLayerSlider(true);
    })
    $('select[name=text_style]').change(function () {
      $('.layer[id=' + currentSlideIndex + '-' + currentLayerIndex + ']').removeClass($captionclasses).addClass($(this).val());
    });
    $('#content-type').find('#layer-text').keyup(function () {
        $slides[currentSlideIndex].layers[currentLayerIndex].text = $(this).val();
        $('#' + currentSlideIndex + '-' + currentLayerIndex).find('.inner').html($(this).val());
        var layertitle = stripHTML($(this).val()).substring(0, 15) + '...';
        $('#layerslist li.active > span:first').text(layertitle);
      })
      /**Custom css*/
    $('[name=custom_css]').keyup(function () {
      $slides[currentSlideIndex].layers[currentLayerIndex].google_font = $slides[currentSlideIndex].layers[currentLayerIndex].google_font || '';
      var font_style = $slides[currentSlideIndex].layers[currentLayerIndex].font_style || 'regular';
      var custom_css = '';
      if ($slides[currentSlideIndex].layers[currentLayerIndex].google_font != '') {
        custom_css = ';font-family:\'' + $slides[currentSlideIndex].layers[currentLayerIndex].google_font + '\';';
        if (font_style == 'regular') {
          custom_css = custom_css + 'font-weight:400;';
        } else if (font_style.indexOf('italic') != -1) {
          custom_css = custom_css + 'font-style:italic;';
          var font_weight = font_style.replace('italic', '');
          custom_css = custom_css + 'font-weight:' + font_weight + ';';
        } else {
          custom_css = custom_css + 'font-weight:' + font_style + ';';
        }
      }
      if($slides[currentSlideIndex].layers[currentLayerIndex].font_size != ""){
        custom_css = custom_css + 'font-size:'+ $slides[currentSlideIndex].layers[currentLayerIndex].font_size + ';';
      }
      if($slides[currentSlideIndex].layers[currentLayerIndex].font_color != ""){
        custom_css = custom_css + 'color:'+ $slides[currentSlideIndex].layers[currentLayerIndex].font_color + ';';
      }
      //if()
      $slides[currentSlideIndex].layers[currentLayerIndex].custom_css = $(this).val();
      $('#' + currentSlideIndex + '-' + currentLayerIndex).find('.inner').attr('style', $(this).val() + custom_css);
    });
    /**/
    $('[name=font_size]').change(function(){
      $slides[currentSlideIndex].layers[currentLayerIndex].font_size = $(this).val();
      $('[name=custom_css]').trigger('keyup');
    });
    $('[name=font_color]').change(function(){
      $slides[currentSlideIndex].layers[currentLayerIndex].font_color = $(this).val();
      $('[name=custom_css]').trigger('keyup');
    });
    /**Custom class*/
    $('[name=custom_class]').keyup(function () {
      $slides[currentSlideIndex].layers[currentLayerIndex].custom_class = $(this).val();
      $('#' + currentSlideIndex + '-' + currentLayerIndex).find('.inner').attr('class', 'inner').addClass($(this).val());
    });
    /*Global setiings*/
    $settings = $.extend(defaultSettings, $settings);
    $('input.global-settings, select.global-settings, textarea.global-settings').each(function (index) {
      $(this).val($settings[$(this).attr('name')]);
    });
    $('#slidedesign').width($settings.startwidth).height($settings.startheight);

    $('input[name=left],input[name=top],input[name=voffset],input[name=hoffset]').change(function () {
      var $ele = $('#' + currentSlideIndex + '-' + currentLayerIndex),
        top = $('input[name=top]').val(),
        left = $('input[name=left]').val(),
        voffset = $('input[name=voffset]').val(),
        hoffset = $('input[name=hoffset]').val();
      adjustPos($ele, top, left, voffset, hoffset);
    });
    $('input[name=height]').change(function () {
      $('#' + currentSlideIndex + '-' + currentLayerIndex).css({
        height: $(this).val() + 'px'
      });
    });
    $('input[name=video_width]').change(function () {
      $('#' + currentSlideIndex + '-' + currentLayerIndex).css({
        width: $(this).val() + 'px'
      });
    });
    $('input[name=video_height]').change(function () {
      $('#' + currentSlideIndex + '-' + currentLayerIndex).css({
        height: $(this).val() + 'px'
      });
    });
    $('html').keyup(function (e) {
      if (e.keyCode == 46) {
        if ($('.layer-option:focus,.slide-option:focus').length == 0) {
          $('#layerslist').find('li.active').find('.remove-layer').trigger('click');
        }
      }
    });
    $('select[name=data_bgposition]').change(function(){
      $('#slidedesign').css({
        backgroundPosition: $(this).val()
      });
    });
    $('#slide_title').keyup(function(){
      $('#slideslist li.active span:first').text($(this).val());
    });
  });

  function init() {
    $('#slideslist').find('li').remove();
    $($slides).each(function (slideIndex) {
      this.title = this.title || 'Slide #' + (slideIndex + 1);
      addSlideTab(this);
    });
    loadSlide(0);
  }
  /*Slide functions*/
  function addSlideTab(slide) {
    var slideIndex = $slides.indexOf(slide);
    var slideTab = $('<li>').attr('index', slideIndex);
    var slideTabTitle = '';
    if (slide.title == '') {
      slideTabTitle = $('<span>').text('Slide #' + (slideIndex + 1));
    } else {
      slideTabTitle = $('<span>').text(slide.title || 'Slide title');
    }
    slideTabTitle.click(function () {
      if ($(this).hasClass('active')) return;
      saveLayer();
      saveSlide();
      loadSlide(slideIndex);
    })
    var slideTabRemove = $('<span>').text('').addClass('remove-slide fa fa-times-circle');
    var slideTabDuplicate = $('<span>').text('').addClass('duplicate-slide fa fa-copy');
    slideTabRemove.click(function () {
      removeSlide(slide);
    });
    slideTabDuplicate.click(function (e) {
      e.preventDefault();
      duplicateSlide(slide);
    });
    slideTab.append(slideTabTitle).append(slideTabDuplicate).append(slideTabRemove);
    $('#slideslist').append(slideTab);
  }

  function loadSlide(slideIndex) {
    currentSlideIndex = slideIndex;
    $('ul#slideslist').find('li').removeClass('active');
    $('ul#slideslist').find('li[index=' + slideIndex + ']').addClass('active');

    if ($slides[slideIndex].background_image != '') {
      $('#slidedesign').css({
        backgroundImage: 'url(' + $slides[slideIndex].background_image + ')',
        backgroundPosition: $slides[slideIndex].data_bgposition||'center center'
      })
    } else {
      $('#slidedesign').css({
        backgroundImage: 'none'
      })
    }
    $slides[slideIndex].data_delay = $slides[slideIndex].data_delay || $settings.delay;
    $('.slide-option').each(function (index) {
      if (typeof $slides[slideIndex][jQuery(this).attr('name')] != "undefined") {
        $(this).val($slides[slideIndex][jQuery(this).attr('name')]);
      } else {
        $(this).val('');
      }
    });
    /**/
    loadLayers(slideIndex);
  }

  function saveSlide() {
    if ($slides.length == 0) return;
    jQuery('.slide-option').each(function (index) {
      $slides[currentSlideIndex][jQuery(this).attr('name')] = $(this).val();
    });
    $slides[currentSlideIndex].layers.sort(DexpCompare);
  }

  function removeSlide(slide) {
    var slideIndex = $slides.indexOf(slide);
    if (slideIndex > -1) {
      $slides.splice(slideIndex, 1);
      $('ul#slideslist').find('li').remove();
      $($slides).each(function (slideIndex) {
        addSlideTab(this);
      });
      loadSlide(0);
    }
  }

  /*Layer functions*/
  function loadLayers(slideIndex) {
    $('#slidedesign').find('div').remove();
    currentSlideIndex = slideIndex;
    /*Remove all layer tabs*/
    $('#layerslist').find('li').remove();
    /*Load new layer tabs*/
    if (typeof $slides[currentSlideIndex].layers == 'undefined') {
      $slides[currentSlideIndex].layers = new Array();
    }
    $($slides[currentSlideIndex].layers).each(function (layerIndex) {
        this.index = layerIndex;
        if ($slides[currentSlideIndex].layers[layerIndex].removed != 1) {
          addLayerTab(this);
        }
      })
      /*Reset layer option value*/
    $('.layer-option').val('');
    if (typeof $slides[currentSlideIndex].layers[0] != 'undefined') {
      loadLayer(0);
    }
  }

  function addLayerTab(layer) {
    var layerIndex = $slides[currentSlideIndex].layers.indexOf(layer);
    var layertype = layer.type;
    var layerTab = $('<li>').attr('index', layerIndex).addClass(layertype);
    if (layertype == 'text') {
      layer.title = stripHTML(layer.text);
    } else if (layertype == 'image') {
      var m = layer.image.toString().match(/.*\/(.+?)\./);
      if (m && m.length > 1) {
        layer.title = m[1];
      }
    }
    layer.title = layer.title || 'Layer #' + (layerIndex + 1);
    var layerTabTitle = $('<span>').text(layer.title.substring(0, 15) + '...');
    var layerTabRemove = $('<span>').text('').addClass('remove-layer fa fa-times-circle');
    var layerTabDuplicate = $('<span>').attr('title', 'Duplicate this layer').text('').addClass('fa fa-copy');
    var layerTabMove = $('<span>').text('').addClass('move fa fa-arrows-v');
    layerTabTitle.click(function () {
      saveLayer();
      loadLayer(layerIndex);
    });
    layerTabDuplicate.click(function () {
      saveLayer();
      duplicateLayer(layer);
    });
    layerTabRemove.click(function () {
      if (confirm('Are you sure to remove this layer?')) {
        removeLayer(layer);
      }
    });
    layerTab.append(layerTabTitle);
    layerTab.append(layerTabRemove);
    layerTab.append(layerTabDuplicate);
    layerTab.append(layerTabMove);
    $('ul#layerslist').append(layerTab);
    var newLayerDesign = $('<div>').addClass('layer tp-caption').attr('id', currentSlideIndex + '-' + layerIndex);
    newLayerDesign.addClass('caption');
    if (typeof $slides[currentSlideIndex].layers[layerIndex].text_style == 'undefined') {
      $slides[currentSlideIndex].layers[layerIndex].text_style = 'text';
    }
    if ($slides[currentSlideIndex].layers[layerIndex].type == 'text') {
      newLayerDesign.addClass($slides[currentSlideIndex].layers[layerIndex].text_style);
    }
    var content = '';
    var custom_css = $slides[currentSlideIndex].layers[layerIndex].custom_css || '';
    newLayerDesign.addClass($slides[currentSlideIndex].layers[layerIndex].type);
    switch ($slides[currentSlideIndex].layers[layerIndex].type) {
      case 'image':
        content = '<img src="' + $slides[currentSlideIndex].layers[layerIndex].image + '"/>';
        var img = new Image();
        img.onload = function () {
          newLayerDesign.width(Math.round($slides[currentSlideIndex].layers[layerIndex].width || this.width));
          newLayerDesign.height(Math.round($slides[currentSlideIndex].layers[layerIndex].height || this.height));
          newLayerDesign.data({
            imageWidth: this.width,
            imageHeight: this.height
          }).find('.refresh').click(function () {
            newLayerDesign.width(newLayerDesign.data('image-width'));
            newLayerDesign.height(newLayerDesign.data('image-height'));
            $slides[currentSlideIndex].layers[layerIndex].width = newLayerDesign.data('image-width');
            $slides[currentSlideIndex].layers[layerIndex].height = newLayerDesign.data('image-height');
            $('input[name=width]').val(newLayerDesign.data('image-width'));
            $('input[name=height]').val(newLayerDesign.data('image-height'));
          });
        }
        newLayerDesign.append('<span class="refresh fa fa-refresh" title="Restore to original size"></span>');
        img.src = $slides[currentSlideIndex].layers[layerIndex].image;
        break;
      case 'video':
        newLayerDesign.addClass('layer-video');
        var video_width = layer.video_width + 'px',
          video_height = layer.video_height + 'px';
        if (layer.video_fullwidth == 1) {
          video_width = '100%';
          video_height = '100%';
        }
        newLayerDesign.css({
          width: video_width,
          height: video_height
        });
        content = '<div style="width:100%;height:100%;background-image:url(' + layer.html5_video_poster + ')"></div>';
        break;
      case 'text':
        content = '<p style="line-height:100%; margin:0">' + $slides[currentSlideIndex].layers[layerIndex].text + '</p>';
        /**/
        $slides[currentSlideIndex].layers[layerIndex].google_font = $slides[currentSlideIndex].layers[layerIndex].google_font || '';
        $slides[currentSlideIndex].layers[layerIndex].font_style = $slides[currentSlideIndex].layers[layerIndex].font_style || '';
        $('[name=font_style]').find('option').remove();
        if ($slides[currentSlideIndex].layers[layerIndex].google_font != '') {
          addGoogleFont($slides[currentSlideIndex].layers[layerIndex].google_font, $slides[currentSlideIndex].layers[layerIndex].font_style);
          custom_css = custom_css + ';font-family:\'' + $slides[currentSlideIndex].layers[layerIndex].google_font + '\';';
        }
    }
    var inner = $('<div>').addClass('inner');
    if (custom_css != '') {
      inner.attr('style', custom_css);
    }
    inner.html(content);
    newLayerDesign.append(inner);
    var zIndex = $slides[currentSlideIndex].layers[layerIndex].index + 1;
    newLayerDesign.mousedown(function () {
      saveLayer();
      loadLayer(layerIndex);
    }).draggable({
      //containment: "parent",
      drag: function (event, ui) {
        $('input[name=left]').val(ui.position.left);
        $('input[name=top]').val(ui.position.top);
        setLayerPosition(layerIndex, ui.position.top, ui.position.left);
      },
      grid: [5, 5]
    });

    $('#slidedesign').append(newLayerDesign);
    newLayerDesign.css({
      zIndex: zIndex
    });
    setTimeout(function () {
      adjustPos(newLayerDesign, $slides[currentSlideIndex].layers[layerIndex].top, $slides[currentSlideIndex].layers[layerIndex].left, $slides[currentSlideIndex].layers[layerIndex].voffset, $slides[currentSlideIndex].layers[layerIndex].hoffset);
    }, 500);

    $('#layeroptions').show(0);
    try {
      $('#layerslist').sortable('destroy');
    } catch (e) {}
    $('#layerslist').sortable({
      handle: '.move',
      update: function (event, ui) {
        $('#layerslist').find('li').each(function (index) {
          var lindex = $(this).attr('index');
          $slides[currentSlideIndex].layers[lindex].index = index;
        });
        $slides[currentSlideIndex].layers.sort(DexpCompare);
        //saveLayer();
        saveSlide();
        loadSlide(currentSlideIndex);
      }
    });
  }

  function duplicateSlide(slide) {
    saveSlide();
    var newSlideIndex = $slides.length;
    var newSlide = $.extend(true, {}, slide);
    newSlide.index = $slides.length;
    newSlide.title = 'Slide #' + ($slides.length + 1);
    $slides.push(newSlide);
    addSlideTab(newSlide);
  }

  function duplicateLayer(layer) {
    /*Save current layer*/
    saveLayer();
    var newlayer = $.extend(true, {}, layer);
    newlayer.index = $slides[currentSlideIndex].layers.length;
    $slides[currentSlideIndex].layers.push(newlayer);
    addLayerTab(newlayer);
    loadLayer($slides[currentSlideIndex].layers.indexOf(newlayer));
  }

  function loadLayer(layerIndex) {
    currentLayerIndex = layerIndex;
    $('.layer').removeClass('selected');
    $('#' + currentSlideIndex + '-' + layerIndex).addClass('selected');
    $('ul#layerslist').find('li').removeClass('active');
    $('ul#layerslist').find('li[index=' + layerIndex + ']').addClass('active');
    /*Bind layer data*/
    $('.layer-option').each(function (index) {
      if (typeof $slides[currentSlideIndex]['layers'][layerIndex][$(this).attr('name')] != 'undefined') {
        $(this).val($slides[currentSlideIndex]['layers'][layerIndex][$(this).attr('name')]);
      } else {
        $(this).val('');
      }
    });
    if ($slides[currentSlideIndex].layers[layerIndex].type == 'video') {
      $('select[name=video_type]').trigger('change');
      $('select[name=video_fullwidth]').trigger('change');
    }
    if ($slides[currentSlideIndex].layers[layerIndex].type == 'text') {
      $slides[currentSlideIndex].layers[layerIndex].google_font = $slides[currentSlideIndex].layers[layerIndex].google_font || '';
      $slides[currentSlideIndex].layers[layerIndex].font_style = $slides[currentSlideIndex].layers[layerIndex].font_style || '';
      $('[name=font_style]').find('option').remove();
      if ($slides[currentSlideIndex].layers[layerIndex].google_font != '') {
        var font_selected = $.grep(Drupal.settings.google_fonts.items, function (e) {
          return e.value == $slides[currentSlideIndex].layers[layerIndex].google_font;
        });
        if (font_selected.length > 0) {
          $(font_selected[0].variants).each(function (index, el) {
            $('[name=font_style]').append(new Option(el, el));
          });
          $('[name=font_style]').val($slides[currentSlideIndex].layers[layerIndex].font_style);
        }
        addGoogleFont($slides[currentSlideIndex].layers[layerIndex].google_font, $slides[currentSlideIndex].layers[layerIndex].font_style);
        setTimeout(function () {
          $('[name=custom_css]').trigger('keyup');
        }, 1000);
      }
    }
    $("#content-type").tabs({
      selected: $contenttypes[$slides[currentSlideIndex].layers[layerIndex].type],
      active: $contenttypes[$slides[currentSlideIndex].layers[layerIndex].type],
      select: function (event, ui) {
        var $layer = $('#' + currentSlideIndex + '-' + currentLayerIndex);
        $layer.removeClass('layer-video');
        var type = $(ui.tab).parent().data('type');
        var panel = $(ui.panel);
        $slides[currentSlideIndex].layers[currentLayerIndex].type = type;
        $('ul#layerslist li.active').removeClass('video image text').addClass(type);
        if (type == 'image') {
          $layer.removeClass($captionclasses);
          $layer.removeClass('text video').addClass('image');
          var op = $layer.resizable("option");
          $layer.resizable("destroy");
          op.aspectRatio = true;
          $layer.resizable(op);
          panel.find('input').trigger('onchange');
        } else if (type == 'text') {
          $layer.removeClass('image video').addClass('text');
          panel.find('textarea[id=layer-text]').trigger('keyup');
          var op2 = $layer.resizable("option");
          $layer.resizable("destroy");
          op2.aspectRatio = false;
          $layer.resizable(op2);
        } else if (type == 'video') {
          var op3 = $layer.resizable("option");
          $layer.resizable("destroy");
          $layer.removeClass('text image').addClass('video');
          op3.aspectRatio = false;
          $layer.resizable(op3);
          $layer.removeClass($captionclasses);
          $layer.addClass('layer-video');
        }
      },
      activate: function (event, ui) {
        var type = $(ui.newTab[0]).data('type');
        var $layer = $('#' + currentSlideIndex + '-' + currentLayerIndex);
        $layer.removeClass('layer-video');
        var panel = $(ui.newPanel[0]);
        $slides[currentSlideIndex].layers[currentLayerIndex].type = type;
        $('ul#layerslist li.active').removeClass('video image text').addClass(type);
        if (type == 'image') {
          $layer.removeClass($captionclasses);
          $layer.removeClass('text video').addClass('image');
          var op = $layer.resizable("option");
          $layer.resizable("destroy");
          op.aspectRatio = true;
          $layer.resizable(op);
          panel.find('input').trigger('onchange');
        } else if (type == 'text') {
          panel.find('textarea[id=layer-text]').trigger('keyup');
          var op2 = $layer.resizable("option");
          $layer.resizable("destroy");
          $layer.removeClass('image video').addClass('text');
          op2.aspectRatio = false;
          $layer.resizable(op2);
        } else if (type == 'video') {
          var op3 = $layer.resizable("option");
          $layer.resizable("destroy");
          $layer.removeClass('text image').addClass('video');
          op3.aspectRatio = false;
          $layer.resizable(op3);
          $layer.removeClass($captionclasses);
          $layer.addClass('layer-video');
        }
      }
    });
  }

  function setLayerPosition($layerIndex, top, left) {
    $slides[currentSlideIndex].layers[$layerIndex].top = top;
    $slides[currentSlideIndex].layers[$layerIndex].left = left;
  }

  function saveLayer() {
    if ($slides.length == 0) {
      return;
    }
    if ($slides[currentSlideIndex].layers.length == 0) {
      return;
    }
    $('.layer-option').each(function (index) {
      $slides[currentSlideIndex].layers[currentLayerIndex][$(this).attr('name')] = $(this).val();
    })
  }

  function removeLayer(layer) {
    var layerIndex = $slides[currentSlideIndex].layers.indexOf(layer);
    if (layerIndex > -1) {
      $slides[currentSlideIndex].layers.splice(layerIndex, 1);
      $('#' + currentSlideIndex + '-' + layerIndex).remove();
      currentLayerIndex = 0;
      loadSlide(currentSlideIndex);
    }
  }

  function saveGlobalSettings() {
    $('input.global-settings, select.global-settings, textarea.global-settings').each(function (index) {
      $settings[$(this).attr('name')] = $(this).val();
    })
  }

  function saveLayerSlider(ajax) {
    saveSlide();
    saveLayer();
    saveGlobalSettings();
    var datasettings = base64Encode(JSON.stringify($settings));
    var dataslides = base64Encode(JSON.stringify($slides));
    var data = {
      sid: $('input[name=sid]').val(),
      data: dataslides,
      settings: datasettings
    };
    $('#save').val('Saving...');
    $.ajax({
      url: Drupal.settings.dexp_layerslider_save_path,
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function (data) {
        $('#save').val('Save');
        if (!ajax) {
          window.location = destination;
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(textStatus + ":" + jqXHR.responseText);
      }
    });
  }
  Drupal.behaviors.dexp_layerslider_admin = {
    attach: function () {
      $('.google-font').autocomplete({
        source: Drupal.settings.google_fonts.items,
        minLength: 3,
        select: function (event, ui) {
          $(ui.item.variants).each(function (index, el) {
            $('[name=font_style]').append(new Option(el, el));
          });
          addGoogleFont(ui.item.value, $('[name=font_style]').val());
          $('[name=custom_css]').trigger('keyup');
        }
      });
      $('[name=font_style]').on('change', function () {
        saveLayer();
        addGoogleFont($('.google-font').val(), $('[name=font_style]').val());
        $('[name=custom_css]').trigger('keyup');
      });
    }
  }
})(jQuery);
