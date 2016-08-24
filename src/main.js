require('es6-object-assign').polyfill()

require('./stylus/main.styl')

import DOMReady from 'detect-dom-ready'

DOMReady(function () {
  // Information about the promotion is bootstrapped from the server
  // var agreablePromoData = window.agreablePromoData

  console.log('agreablt-advert-plugin JS init')


  // let rootElement = document.getElementById('agreable-promotion')

  // React.render(
  //   <Provider store={store}>
  //     {() => <App />}
  //   </Provider>,
  //   rootElement
  // )
})
