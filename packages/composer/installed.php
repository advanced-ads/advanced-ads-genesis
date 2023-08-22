<?php return array(
    'root' => array(
        'name' => 'advanced-ads/advanced-ads-genesis',
        'pretty_version' => '1.42.1',
        'version' => '1.42.1.0',
        'reference' => NULL,
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => false,
    ),
    'versions' => array(
        'advanced-ads/advanced-ads-genesis' => array(
            'pretty_version' => '1.42.1',
            'version' => '1.42.1.0',
            'reference' => NULL,
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'advanced-ads/framework' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '8495decff225c8b628a75d5784cf562e6332a3e2',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../advanced-ads/framework',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
    ),
);
