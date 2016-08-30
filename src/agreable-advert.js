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
    dfp.network = window.agreableAdvert.network;
    dfp.zone = window.agreableAdvert.zone;
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
