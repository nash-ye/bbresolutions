<?php

/**
 * Helper function to access Freemius easily.
 *
 * @return Freemius
 * @since  0.7
 */
function bbr_fs()
{
    global $bbr_fs;

    if (isset($bbr_fs)) {
        return $bbr_fs;
    }

    // Include Freemius SDK.
    require trailingslashit(bbResolutions\PLUGIN_PATH) . 'freemius/start.php';

    $bbr_fs = fs_dynamic_init(
        [
            'id'                  => '6197',
            'slug'                => 'bbresolutions',
            'type'                => 'plugin',
            'public_key'          => 'pk_0861a96a37825f2190d48dffe7493',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => [
                'first-path'     => 'plugins.php',
                'account'        => false,
                'contact'        => false,
                'support'        => false,
            ],
        ]
    );

    return $bbr_fs;
}
