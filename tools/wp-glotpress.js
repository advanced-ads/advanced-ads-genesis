#!/usr/bin/env node
/* eslint-disable no-console */

// Packages.
const chalk = require('chalk');
const fs = require('fs');
const { resolve } = require('path');
const async = require('async');

const packageDetails = require('../package.json');

class GlotPressDownloader {
	baseURL = 'https://translate.wpadvancedads.com/api/projects';

	log(msg) {
		if (!this.isNoConsole) {
			console.log(msg);
		}
	}

	run() {
		this.isNoConsole = process.argv.includes('--no-console');

		try {
			this.log(
				chalk
					.hex('#FADC00')
					.inverse.bold('Downloading Translations from GlotPress')
			);
			this.validateData();
			this.maybeDirectory();
			this.download();
		} catch (error) {
			this.log(chalk.bgRed.bold('Error:') + ' ' + error.message);
		}
	}

	async download() {
		const locales = await this.getGlotPressData();

		if (false === locales) {
			return;
		}

		// Download files.
		async.map(
			Object.keys(locales),
			(locale, callback) => {
				const localeData = locales[locale];

				this.log('');
				this.log(
					chalk.yellow.bold('Updating Language:') +
						` ${chalk.italic(localeData.name)}`
				);

				async.map(['mo', 'po'], (format) => {
					if (this.isNoConsole) {
						process.stdout.write(
							`${this.destination.replace('./', '')}${
								this.potPrefix
							}-${locale}.${format}=${localeData.name}` + '\n'
						);
					}
					this.downloadFile(locale, localeData, format);
				});

				callback(null, true);
			},
			() => {
				this.log('');
				this.log(
					chalk.bgGreen.bold('Success:') +
						' All files has been downloaded.'
				);
			}
		);
	}

	validateData() {
		if (
			undefined === packageDetails.glotpress ||
			Object.keys(packageDetails.glotpress).length < 1
		) {
			throw new Error('The GlotPress settings is not defined.');
		}

		if (
			undefined === packageDetails.glotpress.project ||
			('' === undefined) === packageDetails.glotpress.project
		) {
			throw new Error('The GlotPress project name is not defined.');
		}

		if (
			undefined === packageDetails.glotpress.destination ||
			('' === undefined) === packageDetails.glotpress.destination
		) {
			throw new Error('The destination directory is not defined.');
		}

		// Set data.
		const { project, potPrefix, destination } = packageDetails.glotpress;

		this.project = project;
		this.potPrefix = potPrefix ?? project;
		this.destination = destination;
	}

	maybeDirectory() {
		const destination = resolve(this.destination);

		if (!fs.existsSync(destination)) {
			fs.mkdirSync(destination);
		}
	}

	async getGlotPressData() {
		const response = await fetch(`${this.baseURL}/${this.project}`);
		const data = await response.json();
		const sets = {};

		if (undefined !== data.success && !data.success) {
			this.log(chalk.bgRed.bold('Error:') + ' ' + data.error);
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
	async downloadFile(locale, data, format) {
		this.log(
			chalk.bold(`Downloading: ${this.potPrefix}-${locale}.${format}`)
		);

		const target = `${this.destination}/${this.potPrefix}-${locale}.${format}`;
		const endpoint = `${this.baseURL}/${this.project}/${data.locale}/${data.slug}/export-translations?format=${format}`;

		// Download.
		const response = await fetch(endpoint);
		const content = await response.text();

		fs.writeFileSync(target, content);
	}
}

const downlaoder = new GlotPressDownloader();
downlaoder.run();
