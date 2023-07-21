#!/usr/bin/env node

// Packages.
const chalk = require("chalk");
const fs = require("fs");
const { resolve } = require("path");
const async = require("async");

// Settings.
const package = require("../package.json");
const BASEURL = 'https://translate.wpadvancedads.com/api/projects';

// Validation of settings.
if ( undefined === package.glotpress || Object.keys(package.glotpress).length < 1 ) {
	console.log( chalk.bgRed.bold("Error:") + " The GlotPress settings is not defined." );
	return;
}

if ( undefined === package.glotpress.project || '' === undefined === package.glotpress.project ) {
	console.log( chalk.bgRed.bold("Error:") + " The GlotPress project name is not defined." );
	return;
}

if ( undefined === package.glotpress.destination || '' === undefined === package.glotpress.destination ) {
	console.log( chalk.bgRed.bold("Error:") + " The destination directory is not defined." );
	return;
}

const { glotpress } = package
const { project } = glotpress
let { potPrefix, destination } = glotpress
potPrefix = potPrefix ?? project
destination =resolve(destination)

if (!fs.existsSync(destination)) {
	fs.mkdirSync(destination);
}

async function getGlotPressData() {
	const response = await fetch(`${BASEURL}/${package.glotpress.project}`);
	const data = await response.json();
	const sets = {}
	data.translation_sets.map((set) => {
		if ( set.current_count > 0 ) {
			let id = set.wp_locale;
			if ( 'default' !== set.slug ) {
				id += '_' + set.slug;
			}

			sets[ id ] = set
		}
	})

	return sets
}

// Download Handler.
async function downloadFile(locale, data, format) {
	console.log( chalk.bold("Downloading: " + format));

	const target = `${destination}/${potPrefix}-${locale}.${format}`
	const endpoint = `${BASEURL}/${project}/${data.locale}/${data.slug}/export-translations?format=${format}`

	// Download.
	const response = await fetch(endpoint)
	const content = await response.text();

	fs.writeFileSync(target, content);
}

async function runCommand() {
	const locales = await getGlotPressData();

	// Download files.
	async.map(
		Object.keys(locales),
		(locale, callback) => {
			const localeData = locales[locale]

			console.log("");
			console.log( chalk.bgGreen.bold("Updating Language:") + ` ${chalk.italic(localeData.name)}`);
			async.map(
				['mo', 'po'],
				(format) => downloadFile(locale, localeData, format)
			)

			callback(null, true)
		},
		function(err, results) {
			console.log("");
			console.log(chalk.bgGreen.bold("Success:") + " All files has been downloaded.");
		}
	);
}
runCommand()
