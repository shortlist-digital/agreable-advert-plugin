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
    console.log(advertData)
    console.log(advertSlotId)

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

    if (typeof deviceAdData.postfix === 'object') {
      tagChunks.push(deviceAdData.postfix[0])
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

      if (relativeElementTop < $(window).height() && relativeElementTop > 0) {
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
