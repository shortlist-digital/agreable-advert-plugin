window.googletag = window.googletag || {};
googletag.cmd = googletag.cmd || [];

(function() {

  function loadAdLibrary() {
    console.log('Load ad library')
    var gads = document.createElement("script");
    gads.async = true;
    gads.type = "text/javascript";
    var useSSL = "https:" == document.location.protocol;
    gads.src = (useSSL ? "https:" : "http:") + "//www.googletagservices.com/tag/js/gpt.js";
    var node =document.getElementsByTagName("script")[0];
    node.parentNode.insertBefore(gads, node);

    window.googletag.cmd.push(function() {
      console.log('Ad library loaded')
      googletag.pubads().collapseEmptyDivs()
      googletag.pubads().enableAsyncRendering()
      googletag.enableServices()

      initAdContainers()
    })
  }

  function initAdContainers() {
    $('.advert-container--no-init').each(function(index, advertContainerElement){
      setupAdContainer($(advertContainerElement))
    }.bind(this))
  }

  function setupAdContainer($adContainerEl) {
    console.log('Setup ad container')

    var $advertData = $adContainerEl.find('.advert-data')
    var advertData = JSON.parse($advertData.html())
    var advertSlotId = $advertData.data('id')
    console.log(advertData)
    console.log(advertSlotId)

    window.googletag.cmd.push(function() {
      console.log('Advert widget setup')

      var slot = googletag.defineSlot(
        advertData.tag,
        advertData.creativeSizes,
        advertSlotId
      )
      .addService(googletag.pubads())

      googletag.display(advertSlotId)

    })
  }

  loadAdLibrary()
})();
