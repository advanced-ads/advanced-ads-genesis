module.exports = {
	root: true,
	extends: ['plugin:@wordpress/eslint-plugin/recommended'],
	env: {
		browser: true,
		es6: true,
	},
	globals: {
		jQuery: 'readonly',
		$: 'readonly',
		advancedAds: true,
		ajaxurl: true,
		advadsglobal: true,
	},
	rules: {
		'import/no-unresolved': 'off', // Optional if you're using externals
	},
};
