#!/usr/bin/env node
/* eslint-disable no-console */

// Packages.
const chalk = require('chalk');
const fs = require('fs');
const { resolve } = require('path');
const async = require('async');

// Settings.
const packageDetails = require('../package.json');
const BASEURL = 'https://translate.wpadvancedads.com/api/projects';

// Validation of settings.
function validateSettings() {
	if (
		undefined === packageDetails.glotpress ||
		Object.keys(packageDetails.glotpress).length < 1
	) {
		console.log(
			chalk.bgRed.bold('Error:') +
				' The GlotPress settings is not defined.'
		);
		return false;
	}

	if (
		undefined === packageDetails.glotpress.project ||
		('' === undefined) === packageDetails.glotpress.project
	) {
		console.log(
			chalk.bgRed.bold('Error:') +
				' The GlotPress project name is not defined.'
		);
		return false;
	}

	if (
		undefined === packageDetails.glotpress.destination ||
		('' === undefined) === packageDetails.glotpress.destination
	) {
		console.log(
			chalk.bgRed.bold('Error:') +
				' The destination directory is not defined.'
		);
		return false;
	}

	return true;
}

const { glotpress } = packageDetails;
const { project } = glotpress;
let { potPrefix, destination } = glotpress;
potPrefix = potPrefix ?? project;
destination = resolve(destination);

if (!fs.existsSync(destination)) {
	fs.mkdirSync(destination);
}

async function getGlotPressData() {
	const response = await fetch(
		`${BASEURL}/${packageDetails.glotpress.project}`
	);
	const data = await response.json();
	const sets = {};

	if (undefined !== data.success && !data.success) {
		console.log(chalk.bgRed.bold('Error:') + ' ' + data.error);
		return false;
	}

	data.translation_sets.map((set) => {
		if (set.current_count > 0) {
			let id = set.wp_locale;
			if ('default' !== set.slug) {
				id += '_' + set.slug;
			}

			sets[id] = set;
		}

		return false;
	});

	return sets;
}

// Download Handler.
async function downloadFile(locale, data, format) {
	console.log(chalk.bold('Downloading: ' + format));

	const target = `${destination}/${potPrefix}-${locale}.${format}`;
	const endpoint = `${BASEURL}/${project}/${data.locale}/${data.slug}/export-translations?format=${format}`;

	// Download.
	const response = await fetch(endpoint);
	const content = await response.text();

	fs.writeFileSync(target, content);
}

async function runCommand() {
	const locales = await getGlotPressData();

	if (false === locales) {
		return;
	}

	// Download files.
	async.map(
		Object.keys(locales),
		(locale, callback) => {
			const localeData = locales[locale];

			console.log('');
			console.log(
				chalk.bgGreen.bold('Updating Language:') +
					` ${chalk.italic(localeData.name)}`
			);
			async.map(['mo', 'po'], (format) =>
				downloadFile(locale, localeData, format)
			);

			callback(null, true);
		},
		function () {
			console.log('');
			console.log(
				chalk.bgGreen.bold('Success:') +
					' All files has been downloaded.'
			);
		}
	);
}

if (validateSettings()) {
	runCommand();
}
