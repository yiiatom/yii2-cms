const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
   entry: './src/app.js',
   output: {
      path: path.resolve(__dirname, 'dist'),
      filename: '[name].js',
   },
   stats: {
      hash: false,
      version: false,
      timings: false,
      children: false,
      errorDetails: false,
      warnings: false,
      chunks: false,
      modules: false,
      reasons: false,
      source: false,
      publicPath: false,
   },
   mode: 'production',
   module: {
      rules: [{
         test: /\.(scss|css)$/,
         use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
      }],
   },
   plugins: [
      new MiniCssExtractPlugin({
         filename: 'main.css',
      }),
      new CleanWebpackPlugin(),
   ],
};
