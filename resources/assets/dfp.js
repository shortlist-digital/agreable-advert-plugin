window.googletag = window.googletag || {};
googletag.cmd = googletag.cmd || [];

(function() {

  var advertClassWaitingForVisible = 'advert-container--status-waiting-for-visible'
    , advertClassNoInit = 'advert-container--status-no-init'
    , advertClassRender = 'advert-container--status-render'

  function loadAdLibrary() {
    console.log('AgreableAdPlugin: Load ad library')
    var gads = document.createElement("script");
    gads.async = true;
    gads.type = "text/javascript";
    var useSSL = "https:" == document.location.protocol;
    gads.src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt.js";
    var node =document.getElementsByTagName("script")[0];
    node.parentNode.insertBefore(gads, node);

    APP.adverts = {}

    window.googletag.cmd.push(function() {
      console.log('AgreableAdPlugin: DFP loaded')
      googletag.pubads().collapseEmptyDivs()
      googletag.pubads().enableAsyncRendering()
      googletag.enableServices()

      initAdContainers()
    })
  }

  function initAdContainers() {
    console.log('AgreableAdPlugin: Init ad containers')

    $('.' + advertClassNoInit).each(function(index, advertContainerElement){
      setupAdContainer($(advertContainerElement))
    }.bind(this))
    setInterval(checkForAdSlotsInView.bind(this), 400)
  }

  function setupAdContainer($adContainerEl) {
    console.log('AgreableAdPlugin: Setup ad container')

    var $advertData = $adContainerEl.find('.advert-data')
    var advertData = JSON.parse($advertData.html())
    var advertSlotId = $advertData.data('id')

    window.googletag.cmd.push(function() {
      console.log('AgreableAdPlugin: Advert widget setup')
      var tag = generateAdTag(advertData)

      var createAdSizes = getCreativeAdSizes(advertData)
      console.log('AgreableAdPlugin: Tag - ' + tag)
      console.log('AgreableAdPlugin: Creative Sizes - ' + createAdSizes)

      var slot = googletag.defineSlot(
        tag,
        createAdSizes,
        advertSlotId
      )
      .addService(googletag.pubads())

      slot.setTargeting('ArtName', advertData.art_name)

      if (advertData.category) {
        slot.setTargeting('Section', advertData.category)
      }

      if (advertData.sub_category) {
        slot.setTargeting('SubCat', advertData.sub_category)
        slot.setTargeting('isSubCat', true)
      }

      // slot.setTargeting('Campaign','')

      $adContainerEl
        .removeClass(advertClassNoInit)
        .addClass(advertClassWaitingForVisible)

      window.googletag.pubads().addEventListener('slotRenderEnded', function(event) {
       console.log('AgreableAdPlugin: Creative with id: ' + event.creativeId +
        ' is rendered to slot of size: ' + event.size[0] + 'x' + event.size[1]);

       $adContainerEl.addClass('advert-container--status-rendered')
       window.APP.EventDispatcher.trigger('advert:rendered', $adContainerEl)
      });

    })
  }

  function generateAdTag(advertData) {
    console.warn('This article does not have a category associated with it and may not load ads.')
    var tagChunks = []
    tagChunks.push(advertData.accountPrefix)
    tagChunks.push(advertData.category)
    tagChunks.push(advertData.pageType)
    tagChunks.push(advertData.typeTag)

    var deviceAdData = advertData[getDeviceType(advertData)]

    var basicTag = tagChunks.join('_')

    if (typeof APP.adverts[basicTag] === 'undefined') {
      APP.adverts[basicTag] = {
        advertData: advertData,
        occurrence: 1
      }
    } else {
      APP.adverts[basicTag].occurrence++
    }

    if (typeof deviceAdData.postfix === 'object') {
      var tagPostfix = Math.min(APP.adverts[basicTag].occurrence -1, deviceAdData.postfix.length -1)

      tagChunks.push(deviceAdData.postfix[tagPostfix])
    } else {
      tagChunks.push(deviceAdData.postfix)
    }
    return tagChunks.join('_')
  }

  function getCreativeAdSizes(advertData) {
    var deviceAdData = advertData[getDeviceType(advertData)]
    return deviceAdData.creativeSizes
  }

  function getDeviceType() {
    var windowWidth = $(window).width()
    if (windowWidth >= 1024) {
      return 'desktop'
    } else if (windowWidth >= 768) {
      return 'tablet'
    }
    return 'mobile'
  }

  /**
   * Only render ad slots which are in view to the user
   */
  function checkForAdSlotsInView() {
    var deviceType = getDeviceType()
    $('.widget--show-on-' + deviceType + ' .' + advertClassWaitingForVisible).each(function onAdvertSlot(index, advertSlotEl) {
      var $advertSlot = $(advertSlotEl)

      // Cancel out the scrolltop to normalise the position the elemnt is within the viewport
      var relativeElementTop = $('.advert-container').eq(0).position().top - $(window).scrollTop()

      if (relativeElementTop <= $(window).height() && relativeElementTop >= 0) {
        //In view
        renderAdSlot($advertSlot)
      }

    })
  }

  function renderAdSlot($advertSlot) {
    var adSlotId = $advertSlot.find('.advert-data').data('id')

    console.log('AgreableAdPlugin: render ad slot: ' + adSlotId)

    $advertSlot
      .removeClass(advertClassWaitingForVisible)
      .addClass(advertClassRender)

    googletag.display(adSlotId)
  }

  loadAdLibrary()
})();
