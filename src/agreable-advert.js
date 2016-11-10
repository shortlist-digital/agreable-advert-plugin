require('./stylus/main.styl')

require('es6-object-assign').polyfill()
var $ = require('jquery')
window.$ = $
var dfpLoaded = false

import DOMReady from 'detect-dom-ready'

class AgreableAdvert {

  constructor (param) {
    console.log('Welcome to module AgreableAdvert')
    DOMReady(function () {
      console.log('agreable-advert: Init')

      this.listenForDfpToLoad()

    }.bind(this))
  }

  listenForDfpToLoad() {
    googletag.cmd.push(function () {
      console.log('agreable-advert: DFP loaded')
      dfpLoaded = true

      this.setupDctDfp()

      this.searchForAdvertSlots()
    }.bind(this))
  }

  setupDctDfp() {
    console.log('agreable-advert: Setup DfpDct')
    if (typeof window.agreableAdvert === 'undefined') {
      throw Error('window.agreableAdvert is not set');
    }
    dfp.collapsable = true;

    this.setNetworkAndZone()

    if (typeof window.agreableAdvert.targeting_all === undefined) {
      console.warn('agreablt-advert: No targetting_all defined')
    } else {
      dfp.targeting_all = window.agreableAdvert.targeting_all
    }
  }

  setNetworkAndZone() {

    // Check overrides of Network and Zone
    const getParams = {}
    location.search.substr(1).split('&').forEach(
      (item) => getParams[item.split('=')[0]] = item.split('=')[1]
    )

    dfp.network = getParams.network ?
      getParams.network : window.agreableAdvert.network;

    // Short cut for pointing to Clock's ad network for debugging
    if (dfp.network === 'clock') {
      dfp.network = '65519446'
    }

    dfp.zone = getParams.zone ?
      getParams.zone : window.agreableAdvert.zone;
  }

  searchForAdvertSlots() {
    console.log('agreable-advert: Search for slots')
    $('div[data-agreable-advert][data-status="no-init"]').each(function(index, el) {
      $(el).attr('data-status', 'init')
      var $adSlot = $(el)
      console.log('agreable-advert: New slot found', $adSlot)
      this.setupAdvertSlot($adSlot)
    }.bind(this))

    dfp.enable()

    this.checkAdSlotsAreInView()
  }

  setupAdvertSlot($adSlot) {
    console.log('agreable-advert: Setup ad slot')
    var advertData = JSON.parse( $adSlot.find('script').eq(0).html() )

    if (!advertData) {
      throw Error('Unable to retrieve advert data from <script> tag')
    }

    for (var device in advertData.creative_sizes) {
      console.log('agreable-advert: Device ' + device)
      var deviceCreative = advertData.creative_sizes[device]

      var deviceCreativeString = deviceCreative.map(function(creativeSize) {
        return creativeSize.join('x')
      }).join(',')

      var keyValuesString = ''
      if (advertData.key_values && typeof advertData.key_values === 'object') {
        keyValuesString = advertData.key_values.map(function(a) {
          for (var key in a) {
            return key + '=' + a[key]
          }
        }).join(',')
      }

      $adSlot.append(
        $('<div rel="advert">')
          .addClass(device + '-only')
          .attr('data-sizes', deviceCreativeString)
          .attr('data-targeting', keyValuesString)
      )
    }

  }

  checkAdSlotsAreInView() {

  }


}

module.exports = AgreableAdvert
