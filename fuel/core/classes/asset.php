<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

namespace Fuel\Core;

/**
 * The Asset class allows you to easily work with your apps assets.
 * It allows you to specify multiple paths to be searched for the
 * assets.
 *
 * You can configure the paths by copying the core/config/asset.php
 * config file into your app/config folder and changing the settings.
 *
 * @package     Fuel
 * @subpackage  Core
 */
class Asset
{
	/**
	 * default instance
	 *
	 * @var  array
	 */
	protected static $_instance = null;

	/**
	 * All the Asset instances
	 *
	 * @var  array
	 */
	protected static $_instances = array();

	/**
	 * Default configuration values
	 *
	 * @var  array
	 */
	protected static $default_config = array(
		'paths' => array('assets/'),
		'img_dir' => 'img/',
		'js_dir' => 'js/',
		'css_dir' => 'css/',
		'folders' => array(
			'css' => array(),
			'js'  => array(),
			'img' => array(),
		),
		'url' => '/',
		'add_mtime' => true,
		'indent_level' => 1,
		'indent_with' => "\t",
		'auto_render' => true,
		'fail_silently' => false,
	);

	/**
	 * This is called automatically by the Autoloader.  It loads in the config
	 *
	 * @return  void
	 */
	public static function _init()
	{
		\Config::load('asset', true, false, true);
	}

	/**
	 * Return a specific instance, or the default instance (is created if necessary)
	 *
	 * @param   string $instance instance name
	 * @return  Asset_Instance
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				return false;
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}

	/**
	 * Gets a new instance of the Asset class.
	 *
	 * @param   string $name    instance name
	 * @param   array  $config  default config overrides
	 * @return  Asset_Instance
	 */
	public static function forge($name = 'default', array $config = array())
	{
		if ($exists = static::instance($name))
		{
			\Errorhandler::notice('Asset with this name exists already, cannot be overwritten.');
			return $exists;
		}
		$assetConfig =  \Config::get('asset') ?\Config::get('asset') : [];
		static::$_instances[$name] = new \Asset_Instance(array_merge(static::$default_config, $assetConfig, $config));

		if ($name == 'default')
		{
			static::$_instance = static::$_instances[$name];
		}

		return static::$_instances[$name];
	}

	/**
	 * Adds the given path to the front of the asset paths array.  It adds paths
	 * in a way so that asset paths are used First in Last Out.
	 *
	 * @param   string $path    the path to add
	 * @param   string $type    optional path type (js, css or img)
	 * @return  void
	 */
	public static function add_path($path, $type = null)
	{
		static::instance()->add_path($path, $type);
	}

	/**
	 * Removes the given path from the asset paths array
	 *
	 * @param   string $path the path to remove
	 * @return  void
	 */
	public static function remove_path($path, $type = null)
	{
		static::instance()->remove_path($path, $type);
	}

	/**
	 * Renders the given group.  Each tag will be separated by a line break.
	 * You can optionally tell it to render the files raw.  This means that
	 * all CSS and JS files in the group will be read and the contents included
	 * in the returning value.
	 *
	 * @param   mixed   $group  the group to render
	 * @param   bool    $raw    whether to return the raw file or not
	 * @return  string  the group's output
	 */
	public static function render($group = null, $raw = false)
	{
		return static::instance()->render($group, $raw);
	}

	// --------------------------------------------------------------------

	/**
	 * Static call forwarder
	 *
	 * This can be used when new asset types have been dynamically added
	 *
	 * @param   string  $method  method name
	 * @param   array   $args    passed arguments
	 * @return  mixed
	 * @throws  \BadMethodCallException
	 */
	public static function __callStatic($method, $args)
	{
		// get the default instance
		$instance = static::instance();

		// call the reqiested method
		return call_user_func_array(array($instance, $method), $args);
	}

	// --------------------------------------------------------------------

	/**
	 * CSS
	 *
	 * Either adds the stylesheet to the group, or returns the CSS tag.
	 *
	 * @param	mixed	$stylesheets	The file name, or an array files.
	 * @param	array	$attr			An array of extra attributes
	 * @param	string	$group			The asset group name
	 * @param	bool	$raw			whether to return the raw file or not when group is not set
	 * @return	string
	 */
	public static function css($stylesheets = array(), $attr = array(), $group = NULL, $raw = false)
	{
		return static::instance()->assettype('css', $stylesheets, $attr, $group, $raw);
	}

	// --------------------------------------------------------------------

	/**
	 * JS
	 *
	 * Either adds the javascript to the group, or returns the script tag.
	 *
	 * @param	mixed	$scripts	The file name, or an array files.
	 * @param	array	$attr		An array of extra attributes
	 * @param	string	$group		The asset group name
	 * @param   bool    $raw		whether to return the raw file or not when group is not set
	 * @return	string
	 */
	public static function js($scripts = array(), $attr = array(), $group = NULL, $raw = false)
	{
		return static::instance()->assettype('js', $scripts, $attr, $group, $raw);
	}

	// --------------------------------------------------------------------

	/**
	 * Img
	 *
	 * Either adds the image to the group, or returns the image tag.
	 *
	 * @access	public
	 * @param	mixed	$images The file name, or an array files.
	 * @param	array	$attr   An array of extra attributes
	 * @param	string	$group  The asset group name
	 * @return	string
	 */
	public static function img($images = array(), $attr = array(), $group = NULL)
	{
		return static::instance()->assettype('img', $images, $attr, $group);
	}

	// --------------------------------------------------------------------

	/**
	 * Get File
	 *
	 * Locates a file in all the asset paths, and return it relative to the docroot
	 *
	 * @access	public
	 * @param	string	$file   The filename to locate
	 * @param	string  $type   The type of asset file
	 * @param	string  $folder The sub-folder to look in (optional)
	 * @return	mixed	Either the path to the file or false if not found
	 */
	public static function get_file($file, $type, $folder = '')
	{
		return static::instance()->get_file($file, $type, $folder);
	}

	// --------------------------------------------------------------------

	/**
	 * Find File
	 *
	 * Locates a file in all the asset paths.
	 *
	 * @access	public
	 * @param	string	$file   The filename to locate
	 * @param	string	$type   The type of asset file to search
	 * @param	string	$folder The sub-folder to look in (optional)
	 * @return	mixed	Either the path to the file or false if not found
	 */
	public static function find_file($file, $type, $folder = '')
	{
		return static::instance()->find_file($file, $type, $folder);
	}
}
