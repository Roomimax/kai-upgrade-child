jQuery(document).ready(function ($) {
  // HEADER NAVIGATION START
  function kaiInitHeaderNavigation() {
    const $header = $('#kai-site-header')
    const $panel = $('#kai-panel')
    const $nav = $('#kai-nav')
    const $burger = $('#kai-mobile-burger')
    const mobileQuery = window.matchMedia('(max-width: 991px)')
    let isMobile = mobileQuery.matches

    if (!$header.length || !$panel.length || !$nav.length || !$burger.length) {
      return
    }

    initMenuState()

    $burger.on('click', function (e) {
      e.preventDefault()

      if (!isMobile) {
        return
      }

      if ($header.hasClass('kai-mobile-open')) {
        closeMobileMenu()
      } else {
        openMobileMenu()
      }
    })

    $nav.on('click', '.menu-item-has-children > a', function (e) {
      if (!isMobile) {
        return
      }

      e.preventDefault()

      const $item = $(this).parent('.menu-item')
      const $submenu = $item.children('.sub-menu')

      if (!$submenu.length) {
        return
      }

      if ($item.hasClass('is-open')) {
        closeSubmenu($item)
      } else {
        $item.siblings('.menu-item.is-open').each(function () {
          closeSubmenu($(this))
        })

        openSubmenu($item)
      }
    })

    $nav.on('mouseenter', '.menu-item-has-children', function () {
      if (isMobile) {
        return
      }

      fixDesktopSubmenuDirection()
    })

    function openMobileMenu() {
      $header.addClass('kai-mobile-open')

      $burger
        .addClass('is-active')
        .attr('aria-expanded', 'true')
        .attr('aria-label', 'Закрити меню')

      $panel.attr('aria-hidden', 'false').stop(true, true).slideDown(300)
    }

    function closeMobileMenu() {
      $header.removeClass('kai-mobile-open')

      $burger
        .removeClass('is-active')
        .attr('aria-expanded', 'false')
        .attr('aria-label', 'Відкрити меню')

      closeAllSubmenus()

      $panel.attr('aria-hidden', 'true').stop(true, true).slideUp(300)
    }

    function openSubmenu($item) {
      const $submenu = $item.children('.sub-menu')

      $item.addClass('is-open')
      $submenu.stop(true, true).slideDown(260)
    }

    function closeSubmenu($item) {
      const $submenu = $item.children('.sub-menu')
      const $openedChildren = $item.find('.menu-item.is-open')
      const $childSubmenus = $item.find('.sub-menu')

      $item.removeClass('is-open')
      $openedChildren.removeClass('is-open')

      $submenu.stop(true, true).slideUp(260)
      $childSubmenus.not($submenu).stop(true, true).slideUp(260)
    }

    function closeAllSubmenus() {
      $nav.find('.menu-item.is-open').removeClass('is-open')
      $nav.find('.sub-menu').stop(true, true).slideUp(220)
    }

    function initMenuState() {
      if (isMobile) {
        $header.removeClass('kai-mobile-open')

        $burger
          .removeClass('is-active')
          .attr('aria-expanded', 'false')
          .attr('aria-label', 'Відкрити меню')

        $panel.hide().attr('aria-hidden', 'true')
        $nav.find('.sub-menu').hide()
        $nav.find('.menu-item.is-open').removeClass('is-open')
        $nav.find('.menu-item').removeClass('open-left open-right')
      } else {
        $header.removeClass('kai-mobile-open')

        $burger
          .removeClass('is-active')
          .attr('aria-expanded', 'false')
          .attr('aria-label', 'Відкрити меню')

        $panel.removeAttr('style')
        $panel.removeAttr('aria-hidden')
        $nav.removeAttr('style')
        $nav.find('.sub-menu').removeAttr('style')
        $nav.find('.menu-item.is-open').removeClass('is-open')

        fixDesktopSubmenuDirection()
      }
    }

    function fixDesktopSubmenuDirection() {
      if (mobileQuery.matches) {
        return
      }

      const viewportWidth = window.innerWidth
      const spacing = 16

      $nav.find('.menu-item-has-children').removeClass('open-left open-right')

      $nav.find('.menu-item-has-children').each(function () {
        const $item = $(this)
        const $submenu = $item.children('.sub-menu')

        if (!$submenu.length) {
          return
        }

        const originalStyle = $submenu.attr('style') || ''

        $submenu.css({
          display: 'block',
          visibility: 'hidden',
          opacity: 0,
          pointerEvents: 'none',
        })

        const itemRect = this.getBoundingClientRect()
        const submenuWidth = $submenu.outerWidth()

        const isTopLevelItem =
          $item.parent().hasClass('kai-header-menu') ||
          $item.parent().hasClass('menu')

        if (isTopLevelItem) {
          const wouldOverflowRight =
            itemRect.left + submenuWidth + spacing > viewportWidth

          if (wouldOverflowRight) {
            $item.addClass('open-left')
          } else {
            $item.addClass('open-right')
          }
        } else {
          const wouldOverflowRight =
            itemRect.right + submenuWidth + spacing > viewportWidth
          const wouldOverflowLeft = itemRect.left - submenuWidth - spacing < 0

          if (wouldOverflowRight && !wouldOverflowLeft) {
            $item.addClass('open-left')
          } else {
            $item.addClass('open-right')
          }
        }

        if (originalStyle) {
          $submenu.attr('style', originalStyle)
        } else {
          $submenu.removeAttr('style')
        }
      })
    }

    $(window).on('resize', function () {
      const nowMobile = mobileQuery.matches

      if (nowMobile !== isMobile) {
        isMobile = nowMobile
        initMenuState()
        return
      }

      if (!isMobile) {
        fixDesktopSubmenuDirection()
      }
    })
  }
  // HEADER NAVIGATION END

  // COURSES BLOCK START
  function kaiInitCourses() {
    const blocks = $('.kai-courses-block')

    if (!blocks.length) {
      return
    }

    if (typeof kaiData === 'undefined') {
      console.warn('kaiData is not defined')
      return
    }

    blocks.each(function (index) {
      const block = $(this)
      const results = block.find('.kai-courses-results')
      const searchInput = block.find('.kai-courses-search__input')
      const buttons = block.find('.kai-courses__btn')
      const loadMoreButton = block.find('.kai-courses-load-more')
      const loadMoreActions = block.find('.kai-courses-actions')
      const loadMoreText = loadMoreButton.find('.kai-courses-load-more__text')
      const loadMoreIcon = loadMoreButton.find('.kai-courses-load-more__icon')
      const loadMoreLoader = loadMoreButton.find(
        '.kai-courses-load-more__loader',
      )
      const loadMoreDefaultText =
        $.trim(loadMoreText.text()) || 'Show more programs'

      if (!results.length) {
        return
      }

      const defaultLimit = parseInt(block.data('limit'), 10) || 8
      const mainTermIds = block.data('main-term-ids') || ''

      const blockCategory = block.data('category')
      const activeButtonCategory = buttons
        .filter('.kai-btn_active')
        .first()
        .data('category')

      let activeCategory =
        blockCategory || activeButtonCategory || 'all'
      let currentLimit = defaultLimit
      let currentSearch = searchInput.val() || ''
      let hasMoreCourses =
        loadMoreButton.length > 0 && !loadMoreButton.prop('hidden')
      let searchTimer = null
      let currentRequest = null
      let requestId = 0
      let restoreScrollAfterLoad = false
      let restoredScrollY = 0

      const isArchivePage =
        $('body').hasClass('post-type-archive-course') ||
        $('.kai-courses-archive').length > 0

      const storageKey =
        'kaiCoursesState:' + window.location.pathname + ':' + index

      function getText(key, fallback) {
        if (
          typeof kaiData !== 'undefined' &&
          kaiData.i18n &&
          kaiData.i18n[key]
        ) {
          return kaiData.i18n[key]
        }

        return fallback
      }

      function getLoaderHtml() {
        return (
          '<div class="kai-courses-loader">' +
          '<span class="spinner-border kai-spinner" role="status" aria-hidden="true"></span>' +
          '</div>'
        )
      }

      function setLoadMoreButtonLoading() {
        if (!loadMoreButton.length) {
          return
        }

        loadMoreButton.prop('disabled', true)

        if (loadMoreText.length) {
          loadMoreText.text(getText('loading', 'Loading...'))
        }

        if (loadMoreIcon.length) {
          loadMoreIcon.prop('hidden', true)
        }

        if (loadMoreLoader.length) {
          loadMoreLoader.prop('hidden', false)
        }
      }

      function restoreLoadMoreButton() {
        if (!loadMoreButton.length) {
          return
        }

        loadMoreButton.prop('disabled', false)

        if (loadMoreText.length) {
          loadMoreText.text(loadMoreDefaultText)
        }

        if (loadMoreIcon.length) {
          loadMoreIcon.prop('hidden', false)
        }

        if (loadMoreLoader.length) {
          loadMoreLoader.prop('hidden', true)
        }

        loadMoreActions.prop('hidden', !hasMoreCourses)
        loadMoreButton.prop('hidden', !hasMoreCourses)
      }

      function setLoading(isLoadMoreRequest) {
        const currentHeight = results.outerHeight()

        if (currentHeight > 0) {
          results.css('min-height', currentHeight + 'px')
        }

        results.addClass('is-loading')

        if (!results.find('.kai-courses-loader').length) {
          results.append(getLoaderHtml())
        }

        if (isLoadMoreRequest) {
          setLoadMoreButtonLoading()
        } else if (loadMoreButton.length) {
          loadMoreButton.prop('disabled', true)
        }
      }

      function unsetLoading() {
        results.removeClass('is-loading')
        results.find('.kai-courses-loader').remove()

        restoreLoadMoreButton()

        setTimeout(function () {
          if (!results.hasClass('is-loading')) {
            results.css('min-height', '')
          }
        }, 150)
      }

      function updateLoadMoreButton(hasMore) {
        hasMoreCourses = !!hasMore

        if (!loadMoreButton.length || !loadMoreActions.length) {
          return
        }

        loadMoreActions.prop('hidden', !hasMoreCourses)
        loadMoreButton.prop('hidden', !hasMoreCourses)
      }

      function setActiveButton(category) {
        buttons.removeClass('kai-btn_active')

        const activeButton = buttons.filter(
          '[data-category="' + category + '"]',
        )

        if (activeButton.length) {
          activeButton.addClass('kai-btn_active')
        } else {
          buttons.filter('[data-category="all"]').addClass('kai-btn_active')
        }
      }

      function saveCoursesState() {
        if (!isArchivePage) {
          return
        }

        const state = {
          activeCategory: activeCategory,
          currentLimit: currentLimit,
          currentSearch: currentSearch,
          scrollY: window.scrollY,
        }

        sessionStorage.setItem(storageKey, JSON.stringify(state))
      }

      function getCoursesState() {
        if (!isArchivePage) {
          return null
        }

        try {
          return JSON.parse(sessionStorage.getItem(storageKey))
        } catch (e) {
          return null
        }
      }

      function loadCourses(isLoadMoreRequest = false) {
        const thisRequestId = ++requestId

        if (currentRequest) {
          currentRequest.abort()
        }

        setLoading(isLoadMoreRequest)

        currentRequest = $.ajax({
          url: kaiData.ajaxUrl,
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'kai_load_courses',
            nonce: kaiData.nonce,
            search: currentSearch,
            category: activeCategory,
            limit: currentLimit,
            main_term_ids: mainTermIds,
          },
          success: function (response) {
            if (thisRequestId !== requestId) {
              return
            }

            if (response && response.success && response.data.html) {
              results.html(response.data.html)

              if (typeof response.data.has_more !== 'undefined') {
                updateLoadMoreButton(response.data.has_more)
              }

              saveCoursesState()

              if (restoreScrollAfterLoad) {
                setTimeout(function () {
                  window.scrollTo(0, restoredScrollY)
                  restoreScrollAfterLoad = false
                }, 100)
              }
            } else {
              results.html(
                '<div class="kai-courses-empty">' +
                  getText('notFound', 'Програм не знайдено.') +
                  '</div>',
              )

              updateLoadMoreButton(false)
              saveCoursesState()
            }
          },
          error: function (xhr, status) {
            if (status === 'abort') {
              return
            }

            if (thisRequestId !== requestId) {
              return
            }

            results.html(
              '<div class="kai-courses-empty">' +
                getText('error', 'Сталася помилка. Спробуйте ще раз.') +
                '</div>',
            )

            updateLoadMoreButton(false)
          },
          complete: function () {
            if (thisRequestId !== requestId) {
              return
            }

            unsetLoading()
            currentRequest = null
          },
        })
      }

      buttons.on('click', function () {
        const btn = $(this)

        activeCategory = btn.data('category') || 'all'
        currentSearch = searchInput.val() || ''
        currentLimit = defaultLimit

        setActiveButton(activeCategory)
        loadCourses()
      })

      searchInput.on('input', function () {
        clearTimeout(searchTimer)

        searchTimer = setTimeout(function () {
          currentSearch = searchInput.val() || ''
          currentLimit = defaultLimit

          loadCourses()
        }, 350)
      })

      loadMoreButton.on('click', function () {
        currentSearch = searchInput.val() || ''
        currentLimit += defaultLimit

        loadCourses(true)
      })

      if (isArchivePage) {
        $(window).on('scroll', function () {
          saveCoursesState()
        })

        const navigationEntry = performance.getEntriesByType('navigation')[0]
        const isBackForward =
          navigationEntry && navigationEntry.type === 'back_forward'

        const savedState = getCoursesState()

        if (isBackForward && savedState) {
          activeCategory = savedState.activeCategory || 'all'
          currentLimit = parseInt(savedState.currentLimit, 10) || defaultLimit
          currentSearch = savedState.currentSearch || ''
          restoredScrollY = parseInt(savedState.scrollY, 10) || 0
          restoreScrollAfterLoad = true

          searchInput.val(currentSearch)
          setActiveButton(activeCategory)

          loadCourses()
        } else {
          sessionStorage.removeItem(storageKey)
        }
      }
    })
  }
  // COURSES BLOCK END

  kaiInitHeaderNavigation()
  kaiInitCourses()

  // SLICK CAROUSEL START
  $('.kai-testimonials').each(function () {
    const $section = $(this)
    const $slider = $section.find('.kai-testimonials__slider')
    const $prev = $section.find('.kai-testimonials__arrow_prev')
    const $next = $section.find('.kai-testimonials__arrow_next')

    if (!$slider.length) {
      return
    }

    if (typeof $.fn.slick !== 'function') {
      console.warn('Slick Carousel не підключений.')
      return
    }

    if ($slider.hasClass('slick-initialized')) {
      return
    }

    $slider.slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      infinite: true,
      speed: 450,
      arrows: true,
      dots: false,
      prevArrow: $prev,
      nextArrow: $next,
      swipe: true,
      touchMove: true,
      draggable: true,
      adaptiveHeight: false,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            arrows: false,
            dots: true,
          },
        },
      ],
    })
  })
  // SLICK CAROUSEL END
})
