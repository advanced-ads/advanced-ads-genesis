module.exports = {
	root: true,
	extends: ['plugin:@wordpress/eslint-plugin/recommended'],
	globals: {
		jQuery: true,
		advancedAds: true,
		ajaxurl: true,
		advadsglobal: true,
	},
	rules: {
		'import/no-unresolved': 'off',
	},
};
