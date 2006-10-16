<?php

require_once 'Swat/Swat.php';
require_once 'Site/Site.php';

/**
 * Container for package wide static methods
 *
 * @package   Admin
 * @copyright 2005 silverorange
 */
class Admin
{
	// {{{ constants

	/**
	 * The package identifier
	 */
	const PACKAGE_ID = 'Admin';

	const GETTEXT_DOMAIN = 'admin';

	// }}}
	// {{{ public static function _()

	public static function _($message)
	{
		return Admin::gettext($message);
	}

	// }}}
	// {{{ public static function gettext()

	public static function gettext($message)
	{
		return dgettext(Admin::GETTEXT_DOMAIN, $message);
	}

	// }}}
	// {{{ public static function ngettext()

	public static function ngettext($singular_message,
		$plural_message, $number)
	{
		return dngettext(Admin::GETTEXT_DOMAIN,
			$singular_message, $plural_message, $number);
	}

	// }}}
	// {{{ public static function setupGettext()

	public static function setupGettext()
	{
		bindtextdomain(Store::GETTEXT_DOMAIN, '@DATA-DIR@/Store/locale');
		bind_textdomain_codeset(Store::GETTEXT_DOMAIN, 'UTF-8');
	}

	// }}}
	// {{{ public static function getDependencies()

	/**
	 * Gets the packages this package depends on
	 *
	 * @return array an array of package IDs that this package depends on.
	 */
	public static function getDependencies()
	{
		return array(Swat::PACKAGE_ID, Site::PACKAGE_ID);
	}

	// }}}

Admin::setupGettext();

}

?>
