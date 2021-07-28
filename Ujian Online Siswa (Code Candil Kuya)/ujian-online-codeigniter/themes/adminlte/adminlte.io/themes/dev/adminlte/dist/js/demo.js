/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
(function ($) {
  'use strict'

  var $sidebar   = $('.control-sidebar')
  var $container = $('<div />', {
    class: 'p-3'
  })

  $sidebar.append($container)

  var navbar_dark_skins = [
    'bg-primary',
    'bg-info',
    'bg-success',
    'bg-danger'
  ]

  var navbar_light_skins = [
    'bg-warning',
    'bg-white',
    'bg-gray-light'
  ]

  $container.append(
    '<h5>Customize AdminLTE</h5><hr class="mb-2"/>'
    + '<h6>Navbar Variants</h6>'
  )

  var $navbar_variants        = $('<div />', {
    'class': 'd-flex'
  })
  var navbar_all_colors       = navbar_dark_skins.concat(navbar_light_skins)
  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function (e) {
    var color = $(this).data('color')
    console.log('Adding ' + color)
    var $main_header = $('.main-header')
    $main_header.removeClass('navbar-dark').removeClass('navbar-light')
    navbar_all_colors.map(function (color) {
      $main_header.removeClass(color)
    })

    if (navbar_dark_skins.indexOf(color) > -1) {
      $main_header.addClass('navbar-dark')
      console.log('AND navbar-dark')
    } else {
      console.log('AND navbar-light')
      $main_header.addClass('navbar-light')
    }

    $main_header.addClass(color)
  })

  $navbar_variants.append($navbar_variants_colors)

  $container.append($navbar_variants)

  var $checkbox_container = $('<div />', {
    'class': 'mb-4'
  })
  var $navbar_border = $('<input />', {
    type   : 'checkbox',
    value  : 1,
    checked: $('.main-header').hasClass('border-bottom'),
    'class': 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      $('.main-header').addClass('border-bottom')
    } else {
      $('.main-header').removeClass('border-bottom')
    }
  })
  $checkbox_container.append($navbar_border)
  $checkbox_container.append('<span>Navbar border</span>')
  $container.append($checkbox_container)


  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success'
  ]

  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success'
  ]

  $container.append('<h6>Dark Sidebar Variants</h6>')
  var $sidebar_variants = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($sidebar_variants)
  $container.append(createSkinBlock(sidebar_colors, function () {
    var color         = $(this).data('color')
    var sidebar_class = 'sidebar-dark-' + color.replace('bg-', '')
    var $sidebar      = $('.main-sidebar')
    sidebar_skins.map(function (skin) {
      $sidebar.removeClass(skin)
    })

    $sidebar.addClass(sidebar_class)
  }))

  $container.append('<h6>Light Sidebar Variants</h6>')
  var $sidebar_variants = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($sidebar_variants)
  $container.append(createSkinBlock(sidebar_colors, function () {
    var color         = $(this).data('color')
    var sidebar_class = 'sidebar-light-' + color.replace('bg-', '')
    var $sidebar      = $('.main-sidebar')
    sidebar_skins.map(function (skin) {
      $sidebar.removeClass(skin)
    })

    $sidebar.addClass(sidebar_class)
  }))

  var logo_skins = navbar_all_colors
  $container.append('<h6>Brand Logo Variants</h6>')
  var $logo_variants = $('<div />', {
    'class': 'd-flex'
  })
  $container.append($logo_variants)
  var $clear_btn = $('<a />', {
    href: 'javascript:void(0)'
  }).text('clear').on('click', function () {
    var $logo = $('.brand-link')
    logo_skins.map(function (skin) {
      $logo.removeClass(skin)
    })
  })
  $container.append(createSkinBlock(logo_skins, function () {
    var color = $(this).data('color')
    var $logo = $('.brand-link')
    logo_skins.map(function (skin) {
      $logo.removeClass(skin)
    })
    $logo.addClass(color)
  }).append($clear_btn))

  function createSkinBlock(colors, callback) {
    var $block = $('<div />', {
      'class': 'd-flex flex-wrap mb-3'
    })

    colors.map(function (color) {
      var $color = $('<div />', {
        'class': (typeof color === 'object' ? color.join(' ') : color) + ' elevation-2'
      })

      $block.append($color)

      $color.data('color', color)

      $color.css({
        width       : '40px',
        height      : '20px',
        borderRadius: '25px',
        marginRight : 10,
        marginBottom: 10,
        opacity     : 0.8,
        cursor      : 'pointer'
      })

      $color.hover(function () {
        $(this).css({ opacity: 1 }).removeClass('elevation-2').addClass('elevation-4')
      }, function () {
        $(this).css({ opacity: 0.8 }).removeClass('elevation-4').addClass('elevation-2')
      })

      if (callback) {
        $color.on('click', callback)
      }
    })

    return $block
  }
})(jQuery)


$(function () {
  'use strict'

  $.get('/adsync?v3=true', function (response) {
    var col = $('<div />').html(response)

    $('.content-wrapper .content').append(col)
  })

  $(document).on('click', '.ad-click-event', function (e) {
    e.preventDefault()
    var category = 'Premium Template'
    var action   = ''
    if ($(e.target).is('img')) {
      action = 'Image Buy Now'
    } else {
      action = $(this).text().toLowerCase().indexOf('buy') > -1 ? 'Buy Now' : 'Preview'
    }

    var label = $(this).attr('href')
    var went  = false

    function go() {
      if (!went) {
        went                 = true
        window.location.href = label
      }
    }

    setTimeout(go, 500)

    ga('send', 'event', {
      eventCategory: category,
      eventAction  : action,
      eventLabel   : label,
      transport    : 'beacon',
      hitCallback  : go,
      dimension1   : window.location.pathname + window.location.search + window.location.hash,
      dimension2   : window.location.host
    })
  })
})

$(function () {
  'use strict'
  var i = $('<i />', { 'class': 'fa fa-star-o' })
  i.css('color', '#fff')
  var a = $('<a />', { href: 'https://themequarry.com' })
  a.append(i)
  var span = $('<span />')
  span.append('Premium Templates')
  span.css('color', '#fff')
  a.append(span)
  var li = $('<li />', { 'class': 'bg-success' })
  li.append(a)
  li.on('mouseover', function () {
    $(this).find('a').first().css('background-color', '#008d4c')
    $(this).find('.fa').removeClass('fa-star-o').addClass('fa-star')
  })
  li.on('mouseout', function () {
    $(this).find('a').first().css('background-color', '#00a65a')
    $(this).find('.fa').removeClass('fa-star').addClass('fa-star-o')
  })
  $('.sidebar-menu').append(li)
})

$(function () {
  'use strict'

  var ds = window.localStorage
  if (ds && ds.getItem('no_show') != null) {
    return
  }

  /**
   * Create ThemeQuarry ad
   */
  var wrapper_css = {
    'padding'    : '20px 30px',
    'background' : '#f39c12',
    'display'    : 'none',
    'z-index'    : '999999',
    'font-size'  : '16px',
    'font-weight': 600
  }

  var link_css = {
    'color'          : 'rgba(255, 255, 255, 0.9)',
    'display'        : 'inline-block',
    'margin-right'   : '10px',
    'text-decoration': 'none'
  }

  var link_hover_css = {
    'text-decoration': 'underline',
    'color'          : '#f9f9f9'
  }

  var btn_css = {
    'margin-top' : '-5px',
    'border'     : '0',
    'box-shadow' : 'none',
    'color'      : '#f39c12',
    'font-weight': '600',
    'background' : '#fff'
  }

  var close_css = {
    'color'    : '#fff',
    'font-size': '20px'
  }

  var wrapper = $('<div />').css(wrapper_css)
  var link    = $('<a />', { href: 'https://themequarry.com' })
    .html('Ready to sell your theme? Submit your theme to our new marketplace now and let over 200k visitors see it!')
    .css(link_css)
    .hover(function () {
      $(this).css(link_hover_css)
    }, function () {
      $(this).css(link_css)
    })
  var btn     = $('<a />', {
    'class': 'btn btn-default btn-sm',
    href   : 'https://themequarry.com'
  }).html('Let\'s Do It!').css(btn_css)
  var close   = $('<a />', {
    'class'         : 'float-right',
    href            : '#',
    'data-toggle'   : 'tooltip',
    'data-placement': 'left',
    'title'         : 'Never show me this again!'
  }).html('&times;')
    .css(close_css)
    .click(function (e) {
      e.preventDefault()
      $(wrapper).slideUp()
      if (ds) {
        ds.setItem('no_show', true)
      }
    })

  wrapper.append(close)
  wrapper.append(link)
  wrapper.append(btn)

  $('.content-wrapper').prepend(wrapper)

  wrapper.hide(4).delay(500).slideDown()
});
(function (i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r
  i[r] = i[r] || function () {
    (i[r].q = i[r].q || []).push(arguments)
  }, i[r].l = 1 * new Date()
  a = s.createElement(o),
    m = s.getElementsByTagName(o)[0]
  a.async = 1
  a.src   = g
  m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga')

ga('create', 'UA-46680343-1', 'auto')
ga('send', 'pageview')
