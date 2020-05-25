<?php
/**
 * Resolutions manager class file.
 * 
 * @package bbResolutions
 * @since   0.1
 */
namespace bbResolutions;

/**
 * Resolutions manager class.
 * 
 * @since 0.1
 */
class Manager
{
    /**
     * The resolutions list.
     *
     * @var   array
     * @since 0.1
     */
    protected static $resolutions = [];


    /*** Methods **************************************************************/

    /**
     * Retrieve all registered resolutions.
     * 
     * @return array
     * @since  0.1
     */
    public static function get_all()
    {
        return self::$resolutions;
    }

    /**
     * Retrieve filtered list of the registered resolutions.
     * 
     * @return array
     * @since  0.1
     */
    public static function filter(array $args, $operator = 'AND')
    {
        return wp_list_filter(self::get_all(), $args, $operator);
    }

    /**
     * Retrieve a registered resolution by key.
     * 
     * @return object|null
     * @since  0.1
     */
    public static function get_by_key($key)
    {
        if (isset(self::$resolutions[ $key ])) {
            return self::$resolutions[ $key ];
        }
    }

    /**
     * Retrieve a registered resolution by value.
     * 
     * @return object|null
     * @since  0.1
     */
    public static function get_by_value($value)
    {
        $resolutions = self::filter(
            [
                'value' => $value,
            ],
            'OR'
        );

        if (empty($resolutions)) {
            return;
        }

        $resolutions = reset($resolutions);

        return $resolutions;
    }

    /**
     * Register a new resolution.
     * 
     * @return bool
     * @since  0.1
     */
    public static function register($key, array $args)
    {
        if (isset(self::$resolutions[ $key ])) {
            return false;
        }

        $args = (object) array_merge(
            [
                'label'     => '', // String
                'value'     => '', // String
                'sticker'   => '', // String
            ],
            $args
        );

        $args->key = $key; // The key clone.

        if (empty($args->value)) {
            $args->value = $args->key; // Always unique.
        } else {
            $resolution = self::get_by_value($args->value);

            if (! is_null($resolution)) {
                return false;
            }
        }

        self::$resolutions[ $key ] = $args;

        return true;
    }

    /**
     * Unregister a resolution.
     * 
     * @return bool
     * @since  0.1
     */
    public static function unregister($key)
    {
        if (! isset(self::$resolutions[ $key ])) {
            return false;
        }

        unset(self::$resolutions[ $key ]);

        return true;
    }
}
