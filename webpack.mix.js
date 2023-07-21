/* eslint-disable import/no-extraneous-dependencies */
// webpack.mix.js

const mix = require('laravel-mix');
const { join } = require('path');
require('./tools/laravel-mix/wp-pot');

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
 * CSS Files
 */
mix.sass('assets/scss/app.scss', 'assets/css/app.min.css', {
	sassOptions: {
		outputStyle: 'compressed',
	},
});

/**
 * JavaScript Files
 */
mix.js('assets/src/app.js', 'assets/js/app.js');

/**
 * WordPress translation
 */
mix.wpPot({
	output: '/languages/',
	file: 'advanced-ads-genesis.pot',
	skipJS: true,
	domain: 'advanced-ads-genesis',
});
