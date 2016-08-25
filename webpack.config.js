var webpack = require('webpack')
var nib = require('nib')
var path = require('path')
var ExtractTextPlugin = require("extract-text-webpack-plugin")

var buildPath = path.resolve(__dirname, 'resources', 'assets');
var mainPath = path.resolve(__dirname, 'src', 'main.js');

module.exports = {
  entry: mainPath,
  output: {
    path: buildPath,
    filename: 'app.js'
  },
  module: {
    loaders: [
      { test: /\.styl$/, loader: 'style-loader!css-loader!stylus-loader?paths[]=./src/styles&paths[]=../../themes/agreable-app-theme/styles&paths[]=./node_modules'},
      // { test: /\.styl$/, loader: 'style-loader!css-loader!stylus-loader?paths[]=./styles&paths[]=./node_modules'},
      { test: /\.svg$/, exclude:'node_modules', loader: 'raw-loader' },
      { test: /\.json$/, loader: 'json-loader' },
      { test: /\.js$/, exclude:'node_modules', loader: 'babel-loader?stage=0&loose=all' }
    ]
  },

  plugins: [
    new ExtractTextPlugin('styles.css')
  ],

  resolve: {
    context: __dirname,
    extensions: ['','.js', '.json', '.styl'],
    modulesDirectories: [
      'widgets', 'javascripts', 'web_modules', 'style-atoms', 'node_modules'
    ]
  },

  stylus: {
    use: [nib()]
  }
}
