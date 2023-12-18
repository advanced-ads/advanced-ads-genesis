<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbf6641795e49cef82fe755facdc9c332
{
    public static $files = array (
        'f9e7778b01e598acdf00361562d45920' => __DIR__ . '/..' . '/advanced-ads/framework/src/assets.php',
    );

    public static $classMap = array (
        'AdvancedAds\\Framework\\Assets_Registry' => __DIR__ . '/..' . '/advanced-ads/framework/src/class-assets-registry.php',
        'AdvancedAds\\Framework\\Form\\Field' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field.php',
        'AdvancedAds\\Framework\\Form\\Field_Checkbox' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-checkbox.php',
        'AdvancedAds\\Framework\\Form\\Field_Color' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-color.php',
        'AdvancedAds\\Framework\\Form\\Field_Position' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-position.php',
        'AdvancedAds\\Framework\\Form\\Field_Radio' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-radio.php',
        'AdvancedAds\\Framework\\Form\\Field_Selector' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-selector.php',
        'AdvancedAds\\Framework\\Form\\Field_Size' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-size.php',
        'AdvancedAds\\Framework\\Form\\Field_Switch' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-switch.php',
        'AdvancedAds\\Framework\\Form\\Field_Text' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-text.php',
        'AdvancedAds\\Framework\\Form\\Field_Textarea' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-field-textarea.php',
        'AdvancedAds\\Framework\\Form\\Form' => __DIR__ . '/..' . '/advanced-ads/framework/src/form/class-form.php',
        'AdvancedAds\\Framework\\Installation\\Install' => __DIR__ . '/..' . '/advanced-ads/framework/src/installation/class-install.php',
        'AdvancedAds\\Framework\\Interfaces\\Initializer_Interface' => __DIR__ . '/..' . '/advanced-ads/framework/src/interfaces/interface-initializer.php',
        'AdvancedAds\\Framework\\Interfaces\\Integration_Interface' => __DIR__ . '/..' . '/advanced-ads/framework/src/interfaces/interface-integration.php',
        'AdvancedAds\\Framework\\Interfaces\\Routes_Interface' => __DIR__ . '/..' . '/advanced-ads/framework/src/interfaces/interface-routes.php',
        'AdvancedAds\\Framework\\JSON' => __DIR__ . '/..' . '/advanced-ads/framework/src/class-json.php',
        'AdvancedAds\\Framework\\Loader' => __DIR__ . '/..' . '/advanced-ads/framework/src/class-loader.php',
        'AdvancedAds\\Framework\\Notices\\Manager' => __DIR__ . '/..' . '/advanced-ads/framework/src/notices/class-manager.php',
        'AdvancedAds\\Framework\\Notices\\Notice' => __DIR__ . '/..' . '/advanced-ads/framework/src/notices/class-notice.php',
        'AdvancedAds\\Framework\\Notices\\Storage' => __DIR__ . '/..' . '/advanced-ads/framework/src/notices/class-storage.php',
        'AdvancedAds\\Framework\\Updates' => __DIR__ . '/..' . '/advanced-ads/framework/src/class-updates.php',
        'AdvancedAds\\Framework\\Utilities\\Arr' => __DIR__ . '/..' . '/advanced-ads/framework/src/utilities/class-array.php',
        'AdvancedAds\\Framework\\Utilities\\Formatting' => __DIR__ . '/..' . '/advanced-ads/framework/src/utilities/class-formatting.php',
        'AdvancedAds\\Framework\\Utilities\\Params' => __DIR__ . '/..' . '/advanced-ads/framework/src/utilities/class-params.php',
        'AdvancedAds\\Framework\\Utilities\\Str' => __DIR__ . '/..' . '/advanced-ads/framework/src/utilities/class-string.php',
        'AdvancedAds\\Genesis\\Admin' => __DIR__ . '/../..' . '/includes/admin/class-admin.php',
        'AdvancedAds\\Genesis\\Autoloader' => __DIR__ . '/../..' . '/includes/class-autoloader.php',
        'AdvancedAds\\Genesis\\Frontend' => __DIR__ . '/../..' . '/includes/class-frontend.php',
        'AdvancedAds\\Genesis\\Plugin' => __DIR__ . '/../..' . '/includes/class-plugin.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitbf6641795e49cef82fe755facdc9c332::$classMap;

        }, null, ClassLoader::class);
    }
}
