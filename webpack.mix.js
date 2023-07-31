/* eslint-disable import/no-extraneous-dependencies */
// webpack.mix.js

const mix = require('laravel-mix');
const { join } = require('path');
require('./tools/laravel-mix/wp-pot');
const packageData = require('./package.json');

// Local config.
let localConfig = {};

try {
	localConfig = require('./webpack.mix.local');
} catch {}

// Webpack Config.
mix.webpackConfig({
	externals: {
		jquery: 'jQuery',
		lodash: 'lodash',
		moment: 'moment',
	},
});

// Aliasing Paths.
mix.alias({
	'@root': join(__dirname, 'assets/src'),
});

// Browsersync
if (undefined !== localConfig.wpUrl && '' !== localConfig.wpUrl) {
	mix.browserSync({
		proxy: localConfig.wpUrl,
		ghostMode: false,
		notify: false,
		ui: false,
		open: true,
		online: false,
		files: ['assets/css/*.min.css', 'assets/js/*.js', '**/*.php'],
	});
}

/**
 * WordPress translation
 */
mix.wpPot({
	output: packageData.wpPot.output,
	file: packageData.wpPot.file,
	skipJS: true,
	domain: packageData.wpPot.domain,
});
