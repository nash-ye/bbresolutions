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
     * @return void
     * @since 0.2
     */
    public function __construct()
    {
        $this->load_core();
        $this->load_textdomain();
        $this->register_defaults();

        if (did_action('bbp_after_setup_actions')) {
            $this->after_bbpress_setup();
        } else {
            add_action('bbp_after_setup_actions', array( $this, 'after_bbpress_setup' ));
        }

        if (did_action('bp_after_setup_actions')) {
            $this->after_buddypress_setup();
        } else {
            add_action('bp_after_setup_actions', array( $this, 'after_buddypress_setup' ));
        }
    }

    /**
     * @return void
     * @since 0.2
     */
    public function load_core()
    {
        // Load helper functions.
        require trailingslashit(DIR_PATH) . 'src/bbResolutions/src/helpers.php';
    }

    /**
     * Load plugin's translations.
     * 
     * @return void
     * @since  0.2
     */
    public function load_textdomain()
    {
        // Load the plugin translated strings.
        load_plugin_textdomain('bbresolutions', false, basename(DIR_PATH) . '/locales');
    }

    /**
     * Register default resolutions.
     * 
     * @return void
     * @since  0.2
     */
    public function register_defaults()
    {
        Manager::register('not-support', array(
            'label'     => __('Not a Question', 'bbresolutions'),
            'value'     => '1',
        ));

        Manager::register('not-resolved', array(
            'label'     =>  __('Not Resolved', 'bbresolutions'),
            'value'     => '2',
        ));

        Manager::register('resolved', array(
            'label'     =>  __('Resolved', 'bbresolutions'),
            'sticker'   => __('[Resolved]', 'bbresolutions'),
            'value'     => '3',
        ));
    }

    /**
     * Load bbPress related functionality.
     * 
     * @return void
     * @since  0.2
     */
    public function after_bbpress_setup()
    {
        if (function_exists('is_bbpress')) {
            require trailingslashit(DIR_PATH) . 'src/bbResolutions/src/bbpress/topic-control.php';
            require trailingslashit(DIR_PATH) . 'src/bbResolutions/src/bbpress/topic-actions.php';
            require trailingslashit(DIR_PATH) . 'src/bbResolutions/src/bbpress/topic-view.php';
            require trailingslashit(DIR_PATH) . 'src/bbResolutions/src/bbpress/widgets.php';
        }
    }

    /**
     * Load BuddyPress related functionality.
     * 
     * @return void
     * @since  0.2
     */
    public function after_buddypress_setup()
    {
        if (function_exists('is_buddypress')) {
            // TODO: Add support for BuddyPress plugin.
        }
    }
}
