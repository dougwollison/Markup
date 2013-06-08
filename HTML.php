<?php
namespace Markup;

class HTML{
	//Tags that are self closing
	protected static $selfclosing_tags = array('area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');

	//All allowed attributes per tag
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
	
	//Attributes that serve as boolean values
	protected static $boolean_atts = array('allowfullscreen', 'autofocus', 'autoplay', 'checked', 'controls', 'muted', 'disabled', 'formnovalidate', 'loop', 'multiple', 'novalidate', 'readonly', 'required', 'selected');
	
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
		if(in_array($tag, self::$self_closing)){
			$html .= '/>';
		}else{
			$html .= ">$content</$tag>";
		}

		return $html;
	}
}