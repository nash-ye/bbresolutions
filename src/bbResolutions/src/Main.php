<?php
/**
 * Main class file.
 * 
 * @package bbResolutions
 * @since   0.1
 */
namespace bbResolutions;

/**
 * Main class.
 * 
 * @since 0.2
 */
class Main
{
    /**
     * Private constructor.
     *
     * @access private
     * @since  1.0
     */
    private function __construct()
    {
    }

    /**
     * @return void
     * @since  0.7
     */
    public function loadCore()
    {
        // Load helper functions.
        require trailingslashit(PLUGIN_PATH) . 'src/bbResolutions/src/helpers.php';
    }

    /**
     * Load plugin's translations.
     * 
     * @return void
     * @since  0.7
     */
    public function loadTextdomain()
    {
        // Load the plugin translated strings.
        load_plugin_textdomain('bbresolutions', false, basename(PLUGIN_PATH) . '/locales');
    }

    /**
     * Register default resolutions.
     * 
     * @return void
     * @since  0.7
     */
    public function registerDefaults()
    {
        Manager::register(
            'not-support',
            [
                'label'     => __('Not a Question', 'bbresolutions'),
                'value'     => '1',
            ]
        );

        Manager::register(
            'not-resolved',
            [
                'label'     =>  __('Not Resolved', 'bbresolutions'),
                'value'     => '2',
            ]
        );

        Manager::register(
            'resolved',
            [
                'label'     =>  __('Resolved', 'bbresolutions'),
                'sticker'   => __('[Resolved]', 'bbresolutions'),
                'value'     => '3',
            ]
        );
    }

    /**
     * Load bbPress related functionality.
     * 
     * @return void
     * @since  0.2
     */
    public function afterBbpressSetup()
    {
        if (function_exists('is_bbpress')) {
            require trailingslashit(PLUGIN_PATH) . 'src/bbResolutions/src/bbpress/topic-control.php';
            require trailingslashit(PLUGIN_PATH) . 'src/bbResolutions/src/bbpress/topic-actions.php';
            require trailingslashit(PLUGIN_PATH) . 'src/bbResolutions/src/bbpress/topic-view.php';
            require trailingslashit(PLUGIN_PATH) . 'src/bbResolutions/src/bbpress/widgets.php';
        }
    }

    /**
     * Load BuddyPress related functionality.
     * 
     * @return void
     * @since  0.2
     */
    public function afterBuddypressSetup()
    {
        if (function_exists('is_buddypress')) {
            // TODO: Add support for BuddyPress plugin.
        }
    }

    /*** Singleton ************************************************************/

    /**
     * Create plugin's main instance once.
     *
     * @return self
     * @since  1.0
     * @static
     */
    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self;
            $instance->loadCore();
            $instance->loadTextdomain();
            $instance->registerDefaults();

            if (did_action('bbp_after_setup_actions')) {
                $instance->afterBbpressSetup();
            } else {
                add_action('bbp_after_setup_actions', [$instance, 'afterBbpressSetup']);
            }
    
            if (did_action('bp_after_setup_actions')) {
                $instance->afterBuddypressSetup();
            } else {
                add_action('bp_after_setup_actions', [$instance, 'afterBuddypressSetup']);
            }
        }

        return $instance;
    }
}
