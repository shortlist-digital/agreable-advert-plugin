require('./stylus/main.styl')

require('es6-object-assign').polyfill()
var $ = require('jquery')
window.$ = $

var DctDfp = require('./dct-dfp')

import DOMReady from 'detect-dom-ready'

DOMReady(function () {
  var dctDfp = new DctDfp()

  console.log('agreable-advert: Init')

  setupDctDfp()

  searchForAdvertSlots()
})

function setupDctDfp() {
  console.log('agreable-advert: Setup DfpDct')
  if (typeof window.agreableAdvert === 'undefined') {
    throw Error('window.agreableAdvert is not set');
  }
  dfp.collapsable = true;
  dfp.network = window.agreableAdvert.network;
  dfp.zone = window.agreableAdvert.zone;
  dfp.enable();
}

function searchForAdvertSlots() {
  console.log('agreable-advert: Search for slots')
  $('div[data-agreable-advert][data-status="no-init"]').each(function() {
    console.log('agreable-advert: New slot found')
    setupAdvertSlot($adSlot)
  })

  checkAdSlotsAreInView()
}

function setupAdvertSlot($adSlot) {
  console.log('agreable-advert: Setup ad slot')
  $adSlot.append(
    $('<div rel="advert">')
      .attr('data-sizes', '300x600')
      .attr('data-targeting', 'pos=manual,2')
  )
}

function checkAdSlotsAreInView() {

}

