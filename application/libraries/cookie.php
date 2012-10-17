<?php
class Cookie extends Laravel\Cookie {
		/**
	 * Get the value of a cookie. Ignores hashing
	 *
	 * <code>
	 *		// Get the value of the "favorite" cookie
	 *		$favorite = Cookie::get('favorite');
	 *
	 *		// Get the value of a cookie or return a default value
	 *		$favorite = Cookie::get('framework', 'Laravel');
	 * </code>
	 *
	 * @param  string  $name
	 * @param  mixed   $default
	 * @return string
	 */
	public static function get_raw($name, $default = null)
	{
		if (isset(static::$jar[$name])) return static::parse(static::$jar[$name]['value']);

		if ( ! is_null($value = Request::foundation()->cookies->get($name)))
		{
			return $value;
		}

		return value($default);
	}

}