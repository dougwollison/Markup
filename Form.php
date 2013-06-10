<?php
namespace Markup;

if(!class_exists('\Markup\HTML')){
	require(__DIR__.'/HTML.php');
}

class Form extends HTML{
	/**
	 * Utilitiy method; convert the name to an id string
	 *
	 * @param string $name The name of the field to be converet
	 * @return string $id The converted id of the field
	 */
	protected static function name2id($name){
		//Return non-alphanumeric characters with underscores,
		//and trim off excess underscores
		return trim(preg_replace('/\W+/', '_', $name), '_');
	}

	/**
	 * Build a field (label and input) given specific data
	 *
	 * @param string $name The name of the field
	 * @param array $settings The settings for the field
	 * @param mixed $compare Optional The dynamic value to preload the field with
	 */
	public static function field($name, $settings, $compare = null){
		$html = '';

		//Default settings
		$settings = array_merge(array(
			'name' => $name,
			'type' => 'text',
			'id' => self::name2id($name)
		), $settings);

		//Add $type to class setting
		$class = array($settings['type']);
		if(isset($settings['class'])){
			$class = array_merge($class, (array) $settings['class']);
		}
		$settings['class'] = $class;

		//Check if field should be empty, clear $compare if so
		if(in_array('empty', $settings)){
			$compare = null;
		}

		$field = '';


		//Check if values is an associative array
		$is_assoc = isset($settings['values']) && $settings['values'] === array_values($settings['values']);

		$type = $settings['type'];
		switch($type){
			case 'textarea':
				$field = self::label($settings['label'], $settings['id']);
				$field .= self::textarea($compare, $settings);
				break;

			case 'button':
				$field = self::button($settings['text'], $settings);
				break;

			case 'checkbox':
				//If no value is passed, default it to 1
				if(!isset($settings['value'])){
					$settings['value'] = 1;
				}

				//See if this checkbox's value matches $compare, add "checked" to settings if not present
				if($settings['value'] == $compare && !in_array('checked', $settings)){
					$settings[] = 'checked';
				}

				//Build label & input
				$field = self::label($settings['label'], $settings['id']);
				$field .= self::input($settings);
				break;

			case 'radiolist':
			case 'checklist':
				$settings['type'] = str_replace('list', '', $type);

				if(isset($settings['values'])){
					$i = 0;
					foreach($settings['values'] as $val => $label){
						if(!$is_assoc){
							$val = $label;
						}

						$_id = name2id($id.'__'.$val);

						$atts = array(
							'type' => $type,
							'name' => $name,
							'id' => $_id,
							'value' => $val,
							'class' => preg_replace('/\W+/', '-', $val)
						);
						//Check off if this value matches $compare, or if it's a radio list and no $compare is passed
						if(in_array($val, (array) $compare) || ($type == 'radio' && is_null($compare) && $i == 0)){
							$atts[] = 'checked';
						}

						$i++;

						$field .= self::li(
							self::label($label, $_id).
							self::input($atts)
						);
					}

					$field = self::ul($inputs, $settings);
				}
				break;

			case 'select':
				if(isset($settings['values'])){
					foreach($data['values'] as $val => $label){
						$selected = false;
						if(!$is_assoc){
							$val = $label;
						}

						if(is_array($label)){
							//Using option groups
							$group = '';
							$_is_assoc = $label === array_values($label);
							foreach($label as $v => $l){
								$selected = false;
								if(in_array($v, (array) $compare)){
									$selected = true;
								}

								$group .= self::option($l, $v, $selected);
							}
							$field .= self::optgroup($group, $val);
						}else{
							//Main level options
							if(in_array($val, (array) $compare)){
								$selected = true;
							}

							$group .= self::option($label, $value, $selected);
						}
					}

					$field = self::label($settings['label'], $settings['id']);
					$field .= self::select($field, $settings);
				}
				break;

			default:
				//Load value with $compare
				if(!isset($settings['value'])){
					$settings['value'] = $compare;
				}

				$field = self::label($settings['label'], $settings['id']);
				$field .= self::input($settings);
				break;
		}
	}
}