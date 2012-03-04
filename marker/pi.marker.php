<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Markdownifee Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Lee Hilton
 * @link		http://www.leezilla.net
 */

$plugin_info = array(
	'pi_name'		=> 'Marker',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Lee Hilton',
	'pi_author_url'	=> 'http://www.leezilla.net',
	'pi_description'=> 'Marker is an EE 2.x plugin that converts between Markdown and HTML. Both directions are supported.',
	'pi_usage'		=> Marker::usage()
);

class Marker {

	public $return_data = "";
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	public function tomarkdown() {
		require_once "markdownify_extra.php";
		$md = new Markdownify_Extra(false, false, false);
		

		return $md->parseString( $this->cleanString( $this->EE->TMPL->tagdata ) );
	}
	
	public function tohtml() {
		require_once "markdown.php";
		return Markdown( $this->EE->TMPL->tagdata );
	}
	
	/**
	 * The HTML will have a lot of indenting and non-display formatting
	 * that should be removed before applying awesomeness to the system.
	 */
	private function cleanString($str = "") {
    /* Build an array of lines from source tag data */
		$tagData   = explode( "\n", trim( $str ) );
    $cleanData = "";
    
    /* Trim leading and trailing spaces from each line */
		foreach( $tagData as $line ) {
  		$cleanData .= trim( $line ) . "\n";
		}
    /**
     * Give the whole thing one more trim, mostly to get the guraunteed
     * trailing newline cut off.  Also I am a bit OCD about strings.
     */
    $cleanData = trim($cleanData);
    
    return $cleanData;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

Marker is an EE 2.x plugin that converts between Markdown and HTML. Both directions are supported, Markdown -> HTML as well as HTML -> Markdown. Markdown is the creation of John Gruber, information is here:

 * http://daringfireball.net/projects/markdown/
 
HTML is the creation of Tim Berners-Lee, documentation can be found with the W3C

 * http://www.w3.org/

This plugin is an encapsulation of two legendary PHP Markdown libraries. For Markdown -> HTML work I am using PHP Markdown: 

 * http://michelf.com/projects/php-markdown/

For the HTLM -> Markdown work I am using Markdownify:

 * http://milianw.de/projects/markdownify/

In both cases, Extra capabilities are in play:

 * http://michelf.com/projects/php-markdown/extra/

=======================================================================

USAGE

=======================================================================

There are two ways to use Marker. The first is converting from Markdown to HTML:

{exp:marker:tohtml}
	## This is markdown
	
	You can also supply a **channel field tag** for content.
{/exp:marker:tohtml}

This will return some nicely formatted HTML and make the world a more joyous place to live.

You can also convert from HTML to Markdown:

{exp:marker:tomarkdown}
	<h2>This is html</h2>
	<p>You can also supply a <strong>channel field tag</strong> for content.</p>
{/exp:marker:tomarkdown}

This can be a bit more dangerous as complex or poor HTML can loose data in the translation. For example tags with inline style can find themselves destyled once converted to Markdown. To be fair, that is really the philosophy of Markdown. Just be aware that this IS considered a lossy conversion.

<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.marker.php */
/* Location: /system/expressionengine/third_party/marker/pi.marker.php */