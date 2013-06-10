<?php
namespace Markup;

class HTML{
	/**
	 * All tags that should contain no content; they close themselves
	 */
	protected static $selfclosing_tags = array('area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');

	/**
	 * All allowed attributes per tag
	 */
	protected static $allowed_attributes = array(
		//Global attributes
		0 => array('accesskey', 'class', 'contenteditableNew', 'contextmenuNew', 'dir', 'draggableNew', 'dropzoneNew', 'hiddenNew', 'id', 'lang', 'spellcheckNew', 'style', 'tabindex', 'title', 'translate', 'onafterprint', 'onbeforeprint', 'onbeforeunload', 'onerror', 'onhaschange', 'onload', 'onmessage', 'onoffline', 'ononline', 'onpagehide', 'onpageshow', 'onpopstate', 'onredo', 'onresize', 'onstorage', 'onundo', 'onunload'),
		'a' => array('href', 'hreflang', 'media', 'rel', 'target', 'type'),
		'area' => array('alt', 'coords', 'href', 'hreflang', 'media', 'rel', 'shape', 'target', 'type'),
		'audio' => array('autoplay', 'controls', 'loop', 'muted', 'preload', 'src'),
		'bdo' => array('dir'),
		'blockquote' => array('cite'),
		'button' => array('autofocus', 'disabled', 'form', 'formaction', 'formenctype', 'formmethod', 'formnovalidate', 'formtarget', 'name', 'type', 'value'),
		'canvas' => array('height', 'width'),
		'col' => array('align', 'char', 'charoff', 'span', 'valign', 'width'),
		'colgroup' => array('align', 'char', 'charoff', 'span', 'valign', 'width'),
		'command' => array('checked', 'disabled', 'icon', 'label', 'radiogroup', 'type'),
		'del' => array('cite', 'datetime'),
		'details' => array('open'),
		'embed' => array('height', 'src', 'type', 'width'),
		'fieldset' => array('disabled', 'form', 'name'),
		'form' => array('accept', 'accent-charset', 'action', 'autocomplete', 'enctype', 'method', 'name', 'novalidate', 'target'),
		'html' => array('manifest'),
		'iframe' => array('allowfullscreen', 'height', 'name', 'sandbox', 'seamless', 'src', 'srcdoc', 'width'),
		'img' => array('alt', 'crossorigin', 'height', 'ismap', 'src', 'usemap', 'width'),
		'input' => array('accept', 'alt', 'autocomplete', 'autofocus', 'checked', 'disabled', 'form', 'formaction', 'formenctype', 'formmethod', 'formnovalidate', 'formtarget', 'height', 'list', 'max', 'maxlength', 'min', 'multiple', 'name', 'placeholder', 'readonly', 'required', 'size', 'src', 'step', 'type', 'value', 'width'),
		'ins' => array('cite', 'datetime'),
		'keygen' => array('autofocus', 'challenge', 'disabled', 'form', 'keytype', 'name'),
		'label' => array('for', 'form'),
		'li' => array('value'),
		'link' => array('href', 'hreflang', 'media', 'rel', 'sizes', 'type'),
		'map' => array('name'),
		'menu' => array('label', 'type'),
		'meta' => array('charset', 'content', 'http-equiv', 'name', 'scheme'),
		'meter' => array('form', 'high', 'low', 'max', 'min', 'optimum', 'value'),
		'object' => array('data', 'form', 'height', 'name', 'type', 'usemap', 'width'),
		'ol' => array('reversed', 'start', 'type'),
		'optgroup' => array('disabled', 'label'),
		'option' => array('disabled', 'label', 'selected', 'value'),
		'output' => array('for', 'form', 'name'),
		'param' => array('name', 'value'),
		'progress' => array('max', 'value'),
		'q' => array('cite'),
		'script' => array('async', 'charset', 'defer', 'src', 'type'),
		'select' => array('autofocus', 'disabled', 'form', 'multiple', 'name', 'required', 'size'),
		'source' => array('media', 'src', 'type'),
		'style' => array('media', 'scoped', 'type'),
		'table' => array('border', 'cellpadding', 'cellspacing', 'width'),
		'td' => array('colspan', 'headers', 'rowspan'),
		'textarea' => array('autofocus', 'cols', 'disabled', 'form', 'maxlength', 'name', 'placeholder', 'readonly', 'required', 'rows', 'wrap'),
		'th' => array('colspan', 'headers', 'rowspan', 'scope'),
		'time' => array('datetime'),
		'track' => array('default', 'kind', 'label', 'src', 'srclang'),
		'ul' => array('type'),
		'video' => array('autoplay', 'controls', 'height', 'loop', 'muted', 'poster', 'preload', 'src', 'width'),
		'object' => array('data', 'form', 'height', 'name', 'type', 'usemap', 'width'),
	);

	/**
	 * Attributes that serve as boolean values
	 */
	protected static $boolean_atts = array('allowfullscreen', 'autofocus', 'autoplay', 'checked', 'controls', 'muted', 'disabled', 'formnovalidate', 'loop', 'multiple', 'novalidate', 'readonly', 'required', 'selected');

	/**
	 * For overloading methods: the directly settable attributes and their defaults
	 */
	protected static $primary_atts = array(
		'a' => array('href', 'target'),
		'button' => array('type' => 'button', 'name', 'value'),
		'iframe' => array('src', 'width', 'height'),
		'img' => array('src', 'width', 'height', 'alt'),
		'input' => array('name', 'value', 'type' => 'text', 'checked'),
		'label' => array('for'),
		'link' => array('href', 'rel' => 'stylesheet'),
		'meta' => array('name', 'content', 'scheme'),
		'optgroup' => array('label'),
		'option' => array('value', 'selected'),
		'script' => array('src'),
		'select' => array('name', 'value'),
		'style' => array('type' => 'text/css'),
		'div' => array('class')
	);

	/**
	 * Build an HTML element and return the string of it
	 *
	 * @param string $tag The name of the tag to build
	 * @param string|array $content The content of the tag ($atts can be passed here instead)
	 * @param array $atts The list of attributes for the tag
	 *
	 * @return string $html The HTML of the tag
	 */
	public static function build($tag, $content = null, $atts = null){
		//Check if an array was passed as $content, if so, swap with $atts
		if(is_array($content)){
			list($atts, $content) = array($content, $atts);
		}

		$html = "<$tag";

		//Build the array of allowed attributes for this tag
		$allowed_attributes = self::$allowed_attributes[0];
		if(isset(self::$allowed_attributes[$tag])){
			$allowed_attributes = array_merge($allowed_attributes, self::$allowed_attributes[$tag]);
		}

		//Run through the attributes and build the list
		if(is_array($atts)){
			foreach($atts as $attr => $value){
				//Check if the value is actually an attribute added non-associatively
				if(is_numeric($attr)){
					$attr = $value;
				}

				//Make sure it is within the allowed attributes list or the data array
				if(in_array($attr, $allowed_attributes) || ($attr == 'data' && is_array($value))){
					if($attr == 'data'){
						foreach($value as $key => $value){
							$html .= " data-$key=\"$value\"";
						}
					}elseif(in_array($attr, self::$boolean_atts)){
						//Boolean attribute, add without value
						$html .= " $attr";
					}else{
						//If it's an array, implode it with spaces (prett much only use case is class)
						if(is_array($value)){
							$value = implode(' ', $value);
						}

						$html .= " $atts=\"$value\"";
					}
				}
			}
		}

		//Self close the tag or append the content and close
		if(in_array($tag, self::$selfclosing_tags)){
			$html .= '/>';
		}else{
			$html .= ">$content</$tag>";
		}

		return $html;
	}

	/**
	 * Echo the result of the HTML::build()
	 *
	 * @param string $tag The name of the tag to build
	 * @param string|array $content The content of the tag ($atts can be passed here instead)
	 * @param array $atts The list of attributes for the tag
	 */
	public static function render($tag, $content = null, $atts = null){
		echo self::build($tag, $content, $atts);
	}

	/**
	 * Overloading; dynamically build tag processing arguments based on method name
	 *
	 * Uses HTML::$primary_atts as basis for what arguments go to what attributes
	 *
	 * Tags that can hold content must have their content passed first,
	 * then the primary attributes in appropriate order, followed at last
	 * by an array of additional attributes if needed
	 *
	 * Examples:
	 *		HTML::a('my link', 'http://mysite.com', '_blank')
	 *			<a href="http://mysite.com" target="_blank">my link</a>
	 *		HTML::input('myfield', 'myvalue', 'checkbox')
	 *			<input name="myfield" value="myvalue" type="checkbox">
	 *		HTML::input('myfield', 'myvalue')
	 *			<input name="myfield" value="myvalue" type="text">
	 *		HTML::button('Submit', 'submit')
	 *			<button type="checkbox">Submit</button>
	 *		HTML::input('Click Me')
	 *			<button type="button">Click Me</button>
	 *		HTML::label('My Field', 'myfield')
	 *			<label for="myfield">My Field</label>
	 *		HTML::style('*{margin:0}');
	 *			<style type="text/css">*{margin:0}</style>
	 *		HTML::div('My content', 'myclass', array('id' => 'myid'))
	 *			<div class="myclass" id="myid">My content</div>
	 *
	 * @param string $name The name of the method called
	 * @param array $arguments The list of arguments passed
	 */
	public static function __callStatic($name, $arguments){
		//Check if it's a tag with primary attributes
		if(in_array($name, self::$primary_atts)){
			$primaries = self::$primary_atts[$name];

			//If not a self closing tag, first argument must be content
			if(!in_array($tag, self::$selfclosing_tags)){
				$content = array_shift($arguments);
			}else{
				$content = null;
			}

			$atts = array();
			//Run through the $defaults
			foreach($primaries as $primary => $default){
				if(is_numeric($primary)){
					$primary = $default;
					$default = null;
				}

				//Set the default attribute
				$atts[$primary] = $default;

				//See if there is anything left in $arguments
				if($arguments){
					$arg = array_shift($arguments);

					//Check if it's an array, make that the rest of $atts if so
					if(is_array($arg)){
						$atts = array_merge($atts, $arg);
						break;
					}else{
						//Otherwise, assign the value to the current primary attribute

						//But first, see if it's a boolean attribute
						if(in_array($primary, self::$boolean_atts)){
							//Add the boolean attr if $arg tests true
							if($arg){
								$atts[] = $primary;
							}
						}else{
							//Otherwise, make it the value of $arg
							$atts[$primary] = $arg;
						}
					}
				}
			}
		}else{
			if(isset($arguments[0])) $content = $arguments[0];
			if(isset($arguments[1])) $atts = $arguments[1];
		}

		return self::build($name, $content, $atts);
	}
}