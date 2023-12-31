<?php
if (!defined('SMF'))
die('Error');
function EditorMain()
{
global $context, $smcFunc;
checkSession('get');
if (!isset($_REQUEST['view']) || !isset($_REQUEST['message']))
fatal_lang_error('no_access');
$context['sub_template'] = 'sendbody';

	$context['view'] = (int) $_REQUEST['view'];

	// Return the right thing for the mode.
	if ($context['view'])
	{
		$_REQUEST['message'] = strtr($_REQUEST['message'], array('#smcol#' => ';', '#smlt#' => '&lt;', '#smgt#' => '&gt;', '#smamp#' => '&amp;'));
		$context['message'] = bbc_to_html($_REQUEST['message']);
	}
	else
	{
		$_REQUEST['message'] = un_htmlspecialchars($_REQUEST['message']);
		$_REQUEST['message'] = strtr($_REQUEST['message'], array('#smcol#' => ';', '#smlt#' => '&lt;', '#smgt#' => '&gt;', '#smamp#' => '&amp;'));

		$context['message'] = html_to_bbc($_REQUEST['message']);
	}

	$context['message'] = $smcFunc['htmlspecialchars']($context['message']);
}

// Convert only the BBC that can be edited in HTML mode for the editor.
function bbc_to_html($text)
{
	global $modSettings, $smcFunc;

	// What tags do we allow?
	$allowed_tags = array('b', 'u', 'i', 's', 'hr', 'list', 'li', 'font', 'size', 'color', 'img', 'left', 'center', 'right', 'url', 'email', 'ftp', 'sub', 'sup');

	$text = parse_bbc($text, true, '', $allowed_tags);

	// Fix for having a line break then a thingy.
	$text = strtr($text, array('<br /><hr />' => '<hr />', '<br /><div' => '<div'));

	// Note that IE doesn't understand spans really - make them something "legacy"
	$working_html = array(
		'~<del>(.+?)</del>~i' => '<strike>$1</strike>',
		'~<span\sclass="bbc_u">(.+?)</span>~i' => '<u>$1</u>',
		'~<span\sstyle="color:\s*([#\d\w]+);" class="bbc_color">(.+?)</span>~i' => '<font color="$1">$2</font>',
		'~<span\sstyle="font-family:\s*([#\d\w\s]+);" class="bbc_font">(.+?)</span>~i' => '<font face="$1">$2</font>',
		'~<div\sstyle="text-align:\s*(left|right);">(.+?)</div>~i' => '<p align="$1">$2</p>',
	);
	$text = preg_replace(array_keys($working_html), array_values($working_html), $text);

	// Parse unique ID's and disable javascript into the smileys - using the double space.
	$i = 1;
	$text = preg_replace('~(\s|&nbsp;)?<(img\ssrc="' . preg_quote($modSettings['smileys_url'], '~') . '/[^<>]+?/([^<>]+?)"\s*)[^<>]*?border="0" class="smiley" />~e', '\'<\' . ' . 'stripslashes(\'$2\') . \'border="0" alt="" title="" onresizestart="return false;" id="smiley_\' . ' . "\$" .'i++ . \'_$3" style="padding: 0 3px 0 3px;" />\'', $text);

	return $text;
}

// The harder one - wysiwyg to BBC!
function html_to_bbc($text)
{
	global $modSettings, $smcFunc, $sourcedir;

	// Remove any newlines - as they are useless.
	$text = strtr($text, array("\n" => ' ', "\r" => ''));

	// Though some of us love paragraphs the parser will do better with breaks.
	$text = preg_replace('~</p>\s*?<p>~i', '<br />', $text);

	// If there's a trailing break get rid of it - Firefox tends to add one.
	$text = preg_replace('~<br\s?/?>$~i', '', $text);

	// Remove any formatting within code tags.
	if (strpos($text, '[code') !== false)
	{
		$text = preg_replace('~<br\s?/?>~i', '#smf_br_spec_grudge_cool!#', $text);
		$parts = preg_split('~(\[/code\]|\[code(?:=[^\]]+)?\])~i', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

		// Only mess with stuff outside [code] tags.
		for ($i = 0, $n = count($parts); $i < $n; $i++)
		{
			// Value of 2 means we're inside the tag.
			if ($i % 4 == 2)
				$parts[$i] = strip_tags($parts[$i]);
		}

		$text = strtr(implode('', $parts), array('#smf_br_spec_grudge_cool!#' => '<br />'));
	}

	// Do the smileys ultra first!
	preg_match_all('~<img\s+[^<>]*?id="*smiley_\d+_([^<>]+?)[\s"/>]\s*[^<>]*?/*>(\s)?~i', $text, $matches);
	if (!empty($matches))
	{
		// Easy if it's not custom.
		if (empty($modSettings['smiley_enable']))
		{
			$smileysfrom = array('>:D', ':D', '::)', '>:(', ':)', ';)', ';D', ':(', ':o', '8)', ':P', '???', ':-[', ':-X', ':-*', ':\'(', ':-\\', '^-^', 'O0', 'C:-)', '0:)');
			$smileysto = array('evil.gif', 'cheesy.gif', 'rolleyes.gif', 'angry.gif', 'smiley.gif', 'wink.gif', 'grin.gif', 'sad.gif', 'shocked.gif', 'cool.gif', 'tongue.gif', 'huh.gif', 'embarrassed.gif', 'lipsrsealed.gif', 'kiss.gif', 'cry.gif', 'undecided.gif', 'azn.gif', 'afro.gif', 'police.gif', 'angel.gif');

			foreach ($matches[1] as $k => $file)
			{
				$found = array_search($file, $smileysto);
				// Note the weirdness here is to stop double spaces between smileys.
				if ($found)
					$matches[1][$k] = '-[]-smf_smily_start#|#' . $smileysfrom[$found] . '-[]-smf_smily_end#|#';
				else
					$matches[1][$k] = '';
			}
		}
		else
		{
			// Load all the smileys.
			$names = array();
			foreach ($matches[1] as $file)
				$names[] = $file;
			$names = array_unique($names);

			if (!empty($names))
			{
				$request = $smcFunc['db_query']('', '
					SELECT code, filename
					FROM {db_prefix}smileys
					WHERE filename IN ({array_string:smiley_filenames})',
					array(
						'smiley_filenames' => $names,
					)
				);
				$mappings = array();
				while ($row = $smcFunc['db_fetch_assoc']($request))
					$mappings[$row['filename']] = $row['code'];
				$smcFunc['db_free_result']($request);

				foreach ($matches[1] as $k => $file)
					if (isset($mappings[$file]))
						$matches[1][$k] = '-[]-smf_smily_start#|#' . $mappings[$file] . '-[]-smf_smily_end#|#';
			}
		}

		// Replace the tags!
		$text = str_replace($matches[0], $matches[1], $text);

		// Now sort out spaces
		$text = str_replace(array('-[]-smf_smily_end#|#-[]-smf_smily_start#|#', '-[]-smf_smily_end#|#', '-[]-smf_smily_start#|#'), ' ', $text);
	}

	$parts = preg_split('~(<[A-Za-z]+\s*[^<>]*?style="?[^<>"]+"?[^<>]*?(?:/?)>|</[A-Za-z]+>)~', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
	$replacement = '';
	$stack = array();

	foreach ($parts as $part)
	{
		if (preg_match('~(<([A-Za-z]+)\s*[^<>]*?)style="?([^<>"]+)"?([^<>]*?(/?)>)~', $part, $matches) === 1)
		{
			// If it's being closed instantly, we can't deal with it...yet.
			if ($matches[5] === '/')
				continue;
			else
			{
				// Get an array of styles that apply to this element.
				$styles = explode(';', $matches[3]);
				$curElement = $matches[2];
				$precedingStyle = $matches[1];
				$afterStyle = $matches[4];
				$curCloseTags = '';
				$extra_attr = '';

				foreach ($styles as $style_item)
				{
					if (trim($style_item) === '')
						continue;

					// Capture the elements of a single style item (e.g. 'font-weight' and 'bold').
					@list ($style_type, $style_value) = explode(':', strtr($style_item, '=', ':'));

					$style_value = strtolower(trim($style_value));

					switch (strtolower(trim($style_type)))
					{
						case 'font-weight':
							if ($style_value === 'bold')
							{
								$curCloseTags .= '[/b]';
								$replacement .= '[b]';
							}
						break;

						case 'text-decoration':
							if ($style_value == 'underline')
							{
								$curCloseTags .= '[/u]';
								$replacement .= '[u]';
							}
							elseif ($style_value == 'line-through')
							{
								$curCloseTags .= '[/s]';
								$replacement .= '[s]';
							}
						break;

						case 'text-align':
							if ($style_value == 'left')
							{
								$curCloseTags .= '[/left]';
								$replacement .= '[left]';
							}
							elseif ($style_value == 'center')
							{
								$curCloseTags .= '[/center]';
								$replacement .= '[center]';
							}
							elseif ($style_value == 'right')
							{
								$curCloseTags .= '[/right]';
								$replacement .= '[right]';
							}
						break;

						case 'font-style':
							if ($style_value == 'italic')
							{
								$curCloseTags .= '[/i]';
								$replacement .= '[i]';
							}
						break;

						case 'color':
							$curCloseTags .= '[/color]';
							$replacement .= '[color=' . $style_value . ']';
						break;

						case 'font-size':
							$curCloseTags .= '[/size]';
							$replacement .= '[size=' . $style_value . ']';
						break;

						case 'font-family':
							$curCloseTags .= '[/font]';
							$replacement .= '[font=' . $style_value . ']';
						break;

						// This is a hack for images with dimensions embedded.
						case 'width':
						case 'height':
							if (preg_match('~[1-9]\d*~i', $style_value, $dimension) === 1)
								$extra_attr .= ' ' . $style_type . '="' . $dimension[0] . '"';
						break;

						case 'list-style-type':
							if (preg_match('~none|disc|circle|square|decimal|decimal-leading-zero|lower-roman|upper-roman|lower-alpha|upper-alpha|lower-greek|lower-latin|upper-latin|hebrew|armenian|georgian|cjk-ideographic|hiragana|katakana|hiragana-iroha|katakana-iroha~i', $style_value, $listType) === 1)
								$extra_attr .= ' listtype="' . $listType[0] . '"';
						break;
					}
				}

				// If there's something that still needs closing, push it to the stack.
				if (!empty($curCloseTags))
					array_push($stack, array(
							'element' => strtolower($curElement),
							'closeTags' => $curCloseTags
						)
					);
				elseif (!empty($extra_attr))
					$replacement .= $precedingStyle . $extra_attr . $afterStyle;
			}
		}

		elseif (preg_match('~</([A-Za-z]+)>~', $part, $matches) === 1)
		{
			// Is this the element that we've been waiting for to be closed?
			if (!empty($stack) && strtolower($matches[1]) === $stack[count($stack) - 1]['element'])
			{
				$byebyeTag = array_pop($stack);
				$replacement .= $byebyeTag['closeTags'];
			}

			// Must've been something else.
			else
				$replacement .= $part;
		}
		// In all other cases, just add the part to the replacement.
		else
			$replacement .= $part;
	}

	// Now put back the replacement in the text.
	$text = $replacement;

	// Let's pull out any legacy alignments.
	while (preg_match('~<([A-Za-z]+)\s+[^<>]*?(align="*(left|center|right)"*)[^<>]*?(/?)>~i', $text, $matches) != false)
	{
		// Find the position in the text of this tag over again.
		$start_pos = strpos($text, $matches[0]);
		if ($start_pos === false)
			break;

		// End tag?
		if ($matches[4] != '/' && strpos($text, '</' . $matches[1] . '>', $start_pos) !== false)
		{
			$end_length = strlen('</' . $matches[1] . '>');
			$end_pos = strpos($text, '</' . $matches[1] . '>', $start_pos);
		}
		else
		{
			$end_length = 0;
			$end_pos = $start_pos + strlen($matches[0]);
		}

		// Remove the align from that tag so it's never checked again.
		$tag = substr($text, $start_pos, strlen($matches[0]));
		$content = substr($text, $start_pos + strlen($matches[0]), $end_pos - $start_pos - strlen($matches[0]));
		$tag = str_replace($matches[2], '', $tag);

		// Put the tags back into the body.
		$text = substr($text, 0, $start_pos) . '[' . $matches[3] . ']' . $tag . $content . '[/' . $matches[3] . ']' . substr($text, $end_pos + $end_length);
	}

	// Let's do some special stuff for fonts - cause we all love fonts.
	while (preg_match('~<font\s+([^<>]*)>~i', $text, $matches) != false)
	{
		// Find the position of this again.
		$start_pos = strpos($text, $matches[0]);
		$end_pos = false;
		if ($start_pos === false)
			break;

		// This must have an end tag - and we must find the right one.
		$lower_text = strtolower($text);

		$start_pos_test = $start_pos + 4;
		// How many starting tags must we find closing ones for first?
		$start_font_tag_stack = 0;
		while ($start_pos_test < strlen($text))
		{
			// Where is the next starting font?
			$next_start_pos = strpos($lower_text, '<font', $start_pos_test);
			$next_end_pos = strpos($lower_text, '</font>', $start_pos_test);

			// Did we past another starting tag before an end one?
			if ($next_start_pos !== false && $next_start_pos < $next_end_pos)
			{
				$start_font_tag_stack++;
				$start_pos_test = $next_start_pos + 4;
			}
			// Otherwise we have an end tag but not the right one?
			elseif ($start_font_tag_stack)
			{
				$start_font_tag_stack--;
				$start_pos_test = $next_end_pos + 4;
			}
			// Otherwise we're there!
			else
			{
				$end_pos = $next_end_pos;
				break;
			}
		}
		if ($end_pos === false)
			break;

		// Now work out what the attributes are.
		$attribs = fetchTagAttributes($matches[1]);
		$tags = array();
		foreach ($attribs as $s => $v)
		{
			if ($s == 'size')
				$tags[] = array('[size=' . (int) trim($v) . ']', '[/size]');
			elseif ($s == 'face')
				$tags[] = array('[font=' . trim(strtolower($v)) . ']', '[/font]');
			elseif ($s == 'color')
				$tags[] = array('[color=' . trim(strtolower($v)) . ']', '[/color]');
		}

		// As before add in our tags.
		$before = $after = '';
		foreach ($tags as $tag)
		{
			$before .= $tag[0];
			if (isset($tag[1]))
				$after = $tag[1] . $after;
		}

		// Remove the tag so it's never checked again.
		$content = substr($text, $start_pos + strlen($matches[0]), $end_pos - $start_pos - strlen($matches[0]));

		// Put the tags back into the body.
		$text = substr($text, 0, $start_pos) . $before . $content . $after . substr($text, $end_pos + 7);
	}

	// Try our hand at all manner of lists - doesn't matter if we mess up the children as the BBC will clean it.
	$text = preg_replace('~<li>\s*</li>~i', '', $text);
	$text = preg_replace('~<(ul|ol)[^<>]*>\s*</(ul|ol)>~i', '', $text);
	$last_text = '';
	while ($text != $last_text)
	{
		$last_text = $text;
		$text = preg_replace('~(<br\s*/?>\s*){0,1}<(ol|ul)[^<>]*?(listtype="([^<>"\s]+)"[^<>]*?)*>(.+?)</(ol|ul)>~ie', '\'[list\' . (\'$2\' == \'ol\' || \'$2\' == \'OL\' ? \' type=decimal\' : (strlen(\'$4\') > 1 ? \' type=$4\' : \'\')) . \']' . "\n" . '\' . strtr(\'$5\', array(\'\\"\' => \'"\')) . \'[/list]\'', $text);
	}
	$last_text = '';
	while ($text != $last_text)
	{
		$last_text = $text;
		$text = preg_replace('~<li\s*[^<>]*?>(.+?)</li>~i', '[li]$1[/li]' . "\n", $text);
	}

	// I love my own image...
	while (preg_match('~<img\s+([^<>]*)/*>~i', $text, $matches) != false)
	{
		// Find the position of the image.
		$start_pos = strpos($text, $matches[0]);
		if ($start_pos === false)
			break;
		$end_pos = $start_pos + strlen($matches[0]);

		$params = '';
		$had_params = array();
		$src = '';

		$attrs = fetchTagAttributes($matches[1]);
		foreach ($attrs as $attrib => $value)
		{
			if (in_array($attrib, array('width', 'height')))
				$params .= ' ' . $attrib . '=' . (int) $value;
			elseif ($attrib == 'alt' && trim($value) != '')
				$params .= ' alt=' . trim($value);
			elseif ($attrib == 'src')
				$src = trim($value);
		}

		$tag = '';
		if (!empty($src))
		{
			$tag = '[img' . $params . ']' . $src . '[/img]';
		}

		// Replace the tag
		$text = substr($text, 0, $start_pos) . $tag . substr($text, $end_pos);
	}

	// The final bits are the easy ones - tags which map to tags which map to tags - etc etc.
	$tags = array(
		'~<b(\s(.)*?)*?>~i' => '[b]',
		'~</b>~i' => '[/b]',
		'~<i(\s(.)*?)*?>~i' => '[i]',
		'~</i>~i' => '[/i]',
		'~<u(\s(.)*?)*?>~i' => '[u]',
		'~</u>~i' => '[/u]',
		'~<strong(\s(.)*?)*?>~i' => '[b]',
		'~</strong>~i' => '[/b]',
		'~<em(\s(.)*?)*?>~i' => '[i]',
		'~</em>~i' => '[/i]',
		'~<strike(\s(.)*?)*?>~i' => '[s]',
		'~</strike>~i' => '[/s]',
		'~<del(\s(.)*?)*?>~i' => '[s]',
		'~</del>~i' => '[/s]',
		'~<center(\s(.)*?)*?>~i' => '[center]',
		'~</center>~i' => '[/center]',
		'~<pre(\s(.)*?)*?>~i' => '[pre]',
		'~</pre>~i' => '[/pre]',
		'~<sub(\s(.)*?)*?>~i' => '[sub]',
		'~</sub>~i' => '[/sub]',
		'~<sup(\s(.)*?)*?>~i' => '[sup]',
		'~</sup>~i' => '[/sup]',
		'~<tt(\s(.)*?)*?>~i' => '[tt]',
		'~</tt>~i' => '[/tt]',
		'~<table(\s(.)*?)*?>~i' => '[table]',
		'~</table>~i' => '[/table]',
		'~<tr(\s(.)*?)*?>~i' => '[tr]',
		'~</tr>~i' => '[/tr]',
		'~<(td|th)\s[^<>]*?colspan="?(\d{1,2})"?.*?>~ie' => 'str_repeat(\'[td][/td]\', $2 - 1) . \'[td]\'',
		'~<(td|th)(\s(.)*?)*?>~i' => '[td]',
		'~</(td|th)>~i' => '[/td]',
		'~<br\s*/*>~i' => "\n",
		'~<hr[^<>]*>~i' => '[hr]',
	);
	$text = preg_replace(array_keys($tags), array_values($tags), $text);

	// What about URL's - the pain in the ass of the tag world.
	while (preg_match('~<a\s+([^<>]*)>([^<>]*)</a>~i', $text, $matches) != false)
	{
		// Find the position of the URL.
		$start_pos = strpos($text, $matches[0]);
		if ($start_pos === false)
			break;
		$end_pos = $start_pos + strlen($matches[0]);

		$tag_type = 'url';
		$href = '';

		$attrs = fetchTagAttributes($matches[1]);
		foreach ($attrs as $attrib => $value)
		{
			if ($attrib == 'href')
			{
				$href = trim($value);
				if (substr($href, 0, 6) == 'ftp://')
					$tag_type = 'ftp';
				elseif (substr($href, 0, 7) == 'mailto:')
				{
					$tag_type = 'email';
					$href = substr($href, 7);
				}
			}

			// External URL?
			if ($attrib == 'target' && $tag_type == 'url')
			{
				if (trim($value) == '_blank')
					$tag_type == 'iurl';
			}
		}

		$tag = '';
		if ($href != '')
		{
			if ($matches[2] == $href)
				$tag = '[' . $tag_type . ']' . $href . '[/' . $tag_type . ']';
			else
				$tag = '[' . $tag_type . '=' . $href . ']' . $matches[2] . '[/' . $tag_type . ']';
		}

		// Replace the tag
		$text = substr($text, 0, $start_pos) . $tag . substr($text, $end_pos);
	}

	$text = strip_tags($text);

	// Some tags often end up as just dummy tags - remove those.
	$text = preg_replace('~\[[bisu]\]\s*\[/[bisu]\]~', '', $text);

	$text = legalise_bbc($text);

	return $text;
}

// Returns an array of attributes associated with a tag.
function fetchTagAttributes($text)
{
	$attribs = array();
	$key = $value = '';
	$strpos = 0;
	$tag_state = 0; // 0 = key, 1 = attribute with no string, 2 = attribute with string
	for ($i = 0; $i < strlen($text); $i++)
	{
		// We're either moving from the key to the attribute or we're in a string and this is fine.
		if ($text{$i} == '=')
		{
			if ($tag_state == 0)
				$tag_state = 1;
			elseif ($tag_state == 2)
				$value .= '=';
		}
		// A space is either moving from an attribute back to a potential key or in a string is fine.
		elseif ($text{$i} == ' ')
		{
			if ($tag_state == 2)
				$value .= ' ';
			elseif ($tag_state == 1)
			{
				$attribs[$key] = $value;
				$key = $value = '';
				$tag_state = 0;
			}
		}
		// A quote?
		elseif ($text{$i} == '"')
		{
			// Must be either going into or out of a string.
			if ($tag_state == 1)
				$tag_state = 2;
			else
				$tag_state = 1;
		}
		// Otherwise it's fine.
		else
		{
			if ($tag_state == 0)
				$key .= $text{$i};
			else
				$value .= $text{$i};
		}
	}

	// Anything left?
	if ($key != '' && $value != '')
		$attribs[$key] = $value;

	return $attribs;
}

function getMessageIcons($board_id)
{
	global $modSettings, $context, $txt, $settings, $smcFunc;

	if (empty($modSettings['messageIcons_enable']))
	{
		loadLanguage('Post');

		$icons = array(
			array('value' => 'xx', 'name' => $txt['standard']),
			array('value' => 'thumbup', 'name' => $txt['thumbs_up']),
			array('value' => 'thumbdown', 'name' => $txt['thumbs_down']),
			array('value' => 'exclamation', 'name' => $txt['excamation_point']),
			array('value' => 'question', 'name' => $txt['question_mark']),
			array('value' => 'lamp', 'name' => $txt['lamp']),
			array('value' => 'smiley', 'name' => $txt['icon_smiley']),
			array('value' => 'angry', 'name' => $txt['icon_angry']),
			array('value' => 'cheesy', 'name' => $txt['icon_cheesy']),
			array('value' => 'grin', 'name' => $txt['icon_grin']),
			array('value' => 'sad', 'name' => $txt['icon_sad']),
			array('value' => 'wink', 'name' => $txt['icon_wink'])
		);

		foreach ($icons as $k => $dummy)
		{
			$icons[$k]['url'] = $settings['images_url'] . '/post/' . $dummy['value'] . '.gif';
			$icons[$k]['is_last'] = false;
		}
	}
	// Otherwise load the icons, and check we give the right image too...
	else
	{
		if (($temp = cache_get_data('posting_icons-' . $board_id, 480)) == null)
		{
			$request = $smcFunc['db_query']('select_message_icons', '
				SELECT title, filename
				FROM {db_prefix}message_icons
				WHERE id_board IN (0, {int:board_id})',
				array(
					'board_id' => $board_id,
				)
			);
			$icon_data = array();
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$icon_data[] = $row;
			$smcFunc['db_free_result']($request);

			cache_put_data('posting_icons-' . $board_id, $icon_data, 480);
		}
		else
			$icon_data = $temp;

		$icons = array();
		foreach ($icon_data as $icon)
		{
			$icons[] = array(
				'value' => $icon['filename'],
				'name' => $icon['title'],
				'url' => $settings[file_exists($settings['theme_dir'] . '/images/post/' . $icon['filename'] . '.gif') ? 'images_url' : 'default_images_url'] . '/post/' . $icon['filename'] . '.gif',
				'is_last' => false,
			);
		}
	}

	return $icons;
}

// This is an important yet frustrating function - it attempts to clean up illegal BBC caused by browsers like Opera which don't obey the rules!!!
function legalise_bbc($text)
{
	global $modSettings;

	if (strlen($text) < 3)
		return $text;

	// We are going to cycle through the BBC and keep track of tags as they arise - in order. If get to a block level tag we're going to make sure it's not in a non-block level tag!
	// This will keep the order of tags that are open.
	$current_tags = array();
	// This will quickly let us see if the tag is active.
	$active_tags = array();

	$disabled = array();
	// Only do current tags.
	if (!empty($modSettings['disabledBBC']))
		{
			$temp = explode(',', strtolower($modSettings['disabledBBC']));

			foreach ($temp as $tag)
				$disabled[trim($tag)] = true;
		}

		if (empty($modSettings['enableEmbeddedFlash']))
			$disabled['flash'] = true;

	$all_tags = parse_bbc(false);
	$valid_tags = array();
	foreach ($all_tags as $tag)
	{
		if (!isset($disabled[$tag['tag']]))
			$valid_tags[$tag['tag']] = !empty($tag['block_level']);
	}

	// Don't worry if we're in a code/noubbc.
	$in_code_nobbc = false;

	// These keep track of where we are!
	$new_text = $text;
	$new_text_offset = 0;

	// Right - we're going to start by going through the whole lot to make sure we don't have align stuff crossed as this happens load and is stupid!
	$align_tags = array('left', 'center', 'right', 'pre');
	foreach ($align_tags as $k => $tag)
		if (!isset($valid_tags[$tag]))
			unset($align_tags[$k]);
	if (!empty($align_tags))
	{
		$current_tag = '';
		while (preg_match('~\[(/)*(' . implode('|', $align_tags) . ')\]~', $text, $matches) != false)
		{
			// Get the offset first.
			$offset = strpos($text, $matches[0]);

			// Is it a closing tag?
			if ($matches[1] == '/')
			{
				// Is it the current tag?
				if ($matches[2] == $current_tag)
				{
					$current_tag = '';
				}
				// Otherwise delete it - not important!
				else
				{
					$new_text = substr($new_text, 0, $new_text_offset + $offset) . substr($new_text, $new_text_offset + $offset + strlen($matches[0]));
					$new_text_offset -= strlen($matches[0]);
				}
			}
			// Otherwise if it's new and we have a tag already assume we DO want to change and hence close the last one.
			else
			{
				if ($current_tag != '' && $matches[2] != $current_tag)
				{
					$new_text = substr($new_text, 0, $new_text_offset + $offset) . '[/' . $current_tag . ']' . substr($new_text, $new_text_offset + $offset);
					$new_text_offset += strlen('[/' . $current_tag . ']');
				}
				// A repeat tag gets removed.
				elseif ($matches[2] == $current_tag)
				{
					$new_text = substr($new_text, 0, $new_text_offset + $offset) . substr($new_text, $new_text_offset + $offset + strlen($matches[0]));
					$new_text_offset -= strlen($matches[0]);
				}
				$current_tag = $matches[2];
			}

			// Finally trim text again.
			$text = substr($text, $offset + strlen($matches[0]));
			$new_text_offset += $offset + strlen($matches[0]);
		}
	}

	// Quickly remove any tags which are back to back.
	$strip_b2b_tags = array();
	foreach ($valid_tags as $tag => $dummy)
	{
		if ($tag != 'td')
			$strip_b2b_tags['~\[' . $tag . '[^<>\[\]]*\]\s*\[/' . $tag . '\]~'] = '';
	}
	$lastlen = 0;
	while (strlen($new_text) != $lastlen)
	{
		$lastlen = strlen($new_text);
		$new_text = preg_replace(array_keys($strip_b2b_tags), array_values($strip_b2b_tags), $new_text);
	}

	// In case things changed above set these back to normal.
	$in_code_nobbc = false;
	$text = $new_text;
	$new_text_offset = 0;

	for ($i = 0; $i < strlen($text); $i++)
	{
		// Got a start of a tag?
		if ($text{$i} == '[')
		{
			// Is this actually an end tag?
			if ($text{$i + 1} == '/')
			{
				preg_match('~\[/([A-Za-z]+)\]~', substr($text, $i), $matches);
				// Is it valid, eh?
				if (!empty($matches) && isset($valid_tags[$matches[1]]))
				{
					// These are special.
					if ($matches[1] == 'code' || $matches[1] == 'nobbc')
						$in_code_nobbc = false;
					// As long as we're not in code and nobbc and it's been started note it's no longer in action.
					elseif (!$in_code_nobbc && !empty($active_tags[$matches[1]]))
					{
						$to_add_back = array();
						// We need to make sure we have the tags closed in the right order.
						while ($tag = array_pop($current_tags))
						{
							// This was the one we are closing so stop.
							if ($tag['type'] == $matches[1])
							{
								// Remove the right active bit.
								foreach ($active_tags[$matches[1]] as $k => $v)
									if ($v == $tag['content'])
										unset($active_tags[$matches[1]][$k]);
								break;
							}
							else
							{
								$to_add_back[] = $tag;
							}
						}
						// Add the other tags back as they were in the wrong order before.
						foreach (array_reverse($to_add_back) as $tag)
						{
							$new_text = substr($new_text, 0, $i + $new_text_offset) . '[/' . $tag['type'] . ']' . substr($new_text, $i + $new_text_offset);
							$new_text_offset += strlen('[/' . $tag['type'] . ']');
						}
						// And reopen...
						foreach (array_reverse($to_add_back) as $tag)
						{
							$new_text = substr($new_text, 0, $i + strlen($matches[0]) + $new_text_offset) . $tag['content'] . substr($new_text, $i + strlen($matches[0]) + $new_text_offset);
							$new_text_offset += strlen($tag['content']);
						}

						// Set what the tags are these days...
						foreach ($to_add_back as $tag)
							array_push($current_tags, $tag);
					}
					// What if it isn't block level and we've never heard of it? Remove it!
					elseif (!$in_code_nobbc && !$valid_tags[$matches[1]])
					{
						//!!! Do something here?
					}
					// What if it's a block level tag we are ending? We need to close any open tags and reopen them afterwards!
					elseif (!$in_code_nobbc && $valid_tags[$matches[1]])
					{
						// Close all the current tags...
						foreach (array_reverse($current_tags) as $tag)
						{
							$new_text = substr($new_text, 0, $i + $new_text_offset) . '[/' . $tag['type'] . ']' . substr($new_text, $i + $new_text_offset);
							$new_text_offset += strlen('[/' . $tag['type'] . ']');
						}

						// ... and reopen them again.
						foreach ($current_tags as $tag)
						{
							$new_text = substr($new_text, 0, $i + strlen($matches[0]) + $new_text_offset) . $tag['content'] . substr($new_text, $i + strlen($matches[0]) + $new_text_offset);
							$new_text_offset += strlen($tag['content']);
						}
					}
				}

				// Now move on.
				$i += strlen($matches[0]) - 1;
			}
			// Starting a tag.
			else
			{
				// Get the tag.
				preg_match('~\[([A-Za-z]+)[^\]]*\]~', substr($text, $i), $matches);

				// It's possible that this wasn't actually a tag after all - if not continue!
				if (!isset($matches[0]) || strpos(substr($text, $i), $matches[0]) !== 0)
					$matches = array();

				// Is it actually valid?!
				if (!empty($matches) && isset($valid_tags[$matches[1]]))
				{
					// Not block level?
					if (!$in_code_nobbc && !$valid_tags[$matches[1]])
					{
						// Can't have two tags active that are the same - close the previous one!
						if (!empty($active_tags[$matches[1]]) && in_array($matches[0], $active_tags[$matches[1]]))
						{
							// Remove this tag.
							foreach ($active_tags[$matches[1]] as $k => $v)
								if ($v == $matches[0])
								{
									unset($active_tags[$matches[1]][$k]);
									break;
								}

							// First add in the new closing tag...
							$new_text = substr($new_text, 0, $i + $new_text_offset) . '[/' . $matches[1] . ']' . substr($new_text, $i + $new_text_offset);
							$new_text_offset += strlen('[/' . $matches[1] . ']');

							// Then find and remove the next one!
							$tag_offset = strpos($new_text, '[/' . $matches[1] . ']', $i + $new_text_offset);
							if ($tag_offset !== false)
								$new_text = substr($new_text, 0, $tag_offset) . substr($new_text, $tag_offset + strlen('[/' . $matches[1] . ']'));

						}
						$active_tags[$matches[1]][] = $matches[0];
						$tag = array(
							'type' => $matches[1],
							'content' => $matches[0],
						);
						array_push($current_tags, $tag);
					}
					// If it's a block level then we need to close all active tags and reopen them!
					elseif (!$in_code_nobbc)
					{
						// Close all the old ones.
						foreach (array_reverse($current_tags) as $tag)
						{
							$new_text = substr($new_text, 0, $i + $new_text_offset) . '[/' . $tag['type'] . ']' . substr($new_text, $i + $new_text_offset);
							$new_text_offset += strlen('[/' . $tag['type'] . ']');
						}
						// Open all the new ones again - if we're not going into a code type tag!
						if ($matches[1] != 'code' && $matches[1] != 'nobbc')
							foreach ($current_tags as $tag)
							{
								$new_text = substr($new_text, 0, $i + strlen($matches[0]) + $new_text_offset) . $tag['content'] . substr($new_text, $i + strlen($matches[0]) + $new_text_offset);
								$new_text_offset += strlen($tag['content']);
							}
					}

					// If it's code or nobbc we need to note it.
					if ($matches[1] == 'code' || $matches[1] == 'nobbc')
						$in_code_nobbc = true;
				}
				// Move on quite a bit!
				elseif (!empty($matches))
					$i += strlen($matches[0]) - 1;
			}
		}
	}

	// What, there's still some open tags?!
	foreach (array_reverse($current_tags) as $tag)
	{
		$new_text .= '[/' . $tag['type'] . ']';
	}

	// Final clean up of back to back tags.
	$lastlen = 0;
	while (strlen($new_text) != $lastlen)
	{
		$lastlen = strlen($new_text);
		$new_text = preg_replace(array_keys($strip_b2b_tags), array_values($strip_b2b_tags), $new_text);
	}

	return $new_text;
}

// Compatibility function - used in 1.1 for showing a post box.
function theme_postbox($msg)
{
	global $context;

	return template_control_richedit($context['post_box_name']);
}

// Creates a box that can be used for richedit stuff like BBC, Smileys etc.
function create_control_richedit($editorOptions)
{
	global $txt, $modSettings, $options, $smcFunc;
	global $context, $settings, $user_info, $sourcedir, $scripturl;
	loadLanguage('Post');
	assert(isset($editorOptions['id']));
	assert(isset($editorOptions['value']));
	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template']))
	{
		$temp1 = $settings['theme_url'];
		$settings['theme_url'] = $settings['default_theme_url'];

		$temp2 = $settings['images_url'];
		$settings['images_url'] = $settings['default_images_url'];

		$temp3 = $settings['theme_dir'];
		$settings['theme_dir'] = $settings['default_theme_dir'];
	}

	if (empty($context['smileys']) && empty($editorOptions['disable_smiley_box']))
	{
		$context['smileys'] = array(
			'postform' => array(),
			'popup' => array(),
		);
		if (empty($modSettings['smiley_enable']) && $user_info['smiley_set'] != 'none')
			$context['smileys']['postform'][] = array(
			'last' => true,
			);
		elseif ($user_info['smiley_set'] != 'none')
		{
			if (($temp = cache_get_data('posting_smileys', 480)) == null)
			{
				$request = $smcFunc['db_query']('', '
					SELECT code, filename, description, smiley_row, hidden
					FROM {db_prefix}smileys
					WHERE hidden IN (0, 2)
					ORDER BY smiley_row, smiley_order',
					array(
					)
				);
				while ($row = $smcFunc['db_fetch_assoc']($request))
				{
					$row['filename'] = htmlspecialchars($row['filename']);
					$row['description'] = htmlspecialchars($row['description']);

					$context['smileys'][empty($row['hidden']) ? 'postform' : 'popup'][$row['smiley_row']]['smileys'][] = $row;
				}
				$smcFunc['db_free_result']($request);

				cache_put_data('posting_smileys', $context['smileys'], 480);
			}
			else
				$context['smileys'] = $temp;
		}

		// Clean house... add slashes to the code for javascript.
		foreach (array_keys($context['smileys']) as $location)
		{
			foreach ($context['smileys'][$location] as $j => $row)
			{
				$n = count($context['smileys'][$location][$j]['smileys']);
				for ($i = 0; $i < $n; $i++)
				{
					$context['smileys'][$location][$j]['smileys'][$i]['code'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['code']);
					$context['smileys'][$location][$j]['smileys'][$i]['js_description'] = addslashes($context['smileys'][$location][$j]['smileys'][$i]['description']);
				}

				$context['smileys'][$location][$j]['smileys'][$n - 1]['last'] = true;
			}
			if (!empty($context['smileys'][$location]))
				$context['smileys'][$location][count($context['smileys'][$location]) - 1]['last'] = true;
		}
	}

	// Set a flag so the sub template knows what to do...
	$context['show_bbc'] = !empty($modSettings['enableBBC']) && !empty($settings['show_bbc']);

	// Generate a list of buttons that shouldn't be shown - this should be the fastest way to do this.
	if (!empty($modSettings['disabledBBC']))
	{
		$disabled_tags = explode(',', $modSettings['disabledBBC']);
		foreach ($disabled_tags as $tag)
		{
			if ($tag == 'list')
				$context['disabled_tags']['orderlist'] = true;

			$context['disabled_tags'][trim($tag)] = true;
		}
	}

	// Switch the URLs back... now we're back to whatever the main sub template is.  (like folder in PersonalMessage.)
	if (isset($settings['use_default_images']) && $settings['use_default_images'] == 'defaults' && isset($settings['default_template']))
	{
		$settings['theme_url'] = $temp1;
		$settings['images_url'] = $temp2;
		$settings['theme_dir'] = $temp3;
	}
}
function create_control_autosuggest(&$suggestOptions)
{
	global $txt, $modSettings, $options, $smcFunc;
	global $context, $settings, $user_info, $sourcedir;

	// First autosuggest means we need to set up some bits...
	if (empty($context['controls']['autosuggest']))
	{
		loadTemplate('GenericControls');

		$context['html_headers'] .= '
		<script language="JavaScript" type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/suggest.js"></script>';
	}

	// Need an ID and something to search for to suggest!
	assert(isset($suggestOptions['id']));
	assert(isset($suggestOptions['search_type']));
	// Check the search type is registered.
	assert(AutoSuggestHandler($suggestOptions['search_type']));

	// Log this into our collection.
	$context['controls']['autosuggest'][$suggestOptions['id']] = array(
		'id' => $suggestOptions['id'],
		'value' => !empty($suggestOptions['value']) ? $suggestOptions['value'] : '',
		'search_type' => $suggestOptions['search_type'],
		'size' => !empty($suggestOptions['size']) ? $suggestOptions['size'] : 40,
		'width' => !empty($suggestOptions['width']) ? $suggestOptions['width'] : '200px',
		'button' => !empty($suggestOptions['button']) ? $suggestOptions['button'] : false,
		'callbacks' => !empty($suggestOptions['callbacks']) ? $suggestOptions['callbacks'] : array(),
	);
}

// Create a anti-bot verification control?
function create_control_verification(&$verificationOptions, $do_test = false)
{
	global $txt, $modSettings, $options, $smcFunc;
	global $context, $settings, $user_info, $sourcedir, $scripturl;

	// First verification means we need to set up some bits...
	if (empty($context['controls']['verification']))
	{
		// The template
		loadTemplate('GenericControls');

		// Some javascript ma'am?
		if (!empty($verificationOptions['override_visual']) || (!empty($modSettings['visual_verification_type']) && !isset($verificationOptions['override_visual'])))
			$context['html_headers'] .= '
		<script language="JavaScript" type="text/javascript" src="' . $settings['default_theme_url'] . '/scripts/captcha.js"></script>';

		$context['use_graphic_library'] = in_array('gd', get_loaded_extensions());

		// Skip I, J, L, O, Q, S and Z.
		$context['standard_captcha_range'] = array_merge(range('A', 'H'), array('K', 'M', 'N', 'P', 'R'), range('T', 'Y'));
	}

	// Always have an ID.
	assert(isset($verificationOptions['id']));
	$isNew = !isset($context['controls']['verification'][$verificationOptions['id']]);

	// Log this into our collection.
	if ($isNew)
		$context['controls']['verification'][$verificationOptions['id']] = array(
			'id' => $verificationOptions['id'],
			'show_visual' => !empty($verificationOptions['override_visual']) || (!empty($modSettings['visual_verification_type']) && !isset($verificationOptions['override_visual'])),
			'number_questions' => isset($verificationOptions['override_qs']) ? $verificationOptions['override_qs'] : (!empty($modSettings['qa_verification_number']) ? $modSettings['qa_verification_number'] : 0),
			'max_errors' => isset($verificationOptions['max_errors']) ? $verificationOptions['max_errors'] : 3,
			'image_href' => $scripturl . '?action=verificationcode;vid=' . $verificationOptions['id'] . ';rand=' . md5(rand()),
			'text_value' => '',
			'questions' => array(),
		);
	$thisVerification = &$context['controls']['verification'][$verificationOptions['id']];

	// Add javascript for the object.
	$context['insert_after_template'] .= '
		<script language="JavaScript" type="text/javascript"><!-- // --><![CDATA[
		verification' . $verificationOptions['id'] . 'Handle = new smfCaptcha("' . $thisVerification['image_href'] . '", "' . $verificationOptions['id'] . '", ' . ($context['use_graphic_library'] ? 1 : 0) . ');
		// ]]></script>';

	// Is there actually going to be anything?
	if (empty($thisVerification['show_visual']) && empty($thisVerification['number_questions']))
		return false;
	elseif (!$isNew && !$do_test)
		return true;

	// If we want questions do we have a cache of all the IDs?
	if (!empty($thisVerification['number_questions']) && empty($modSettings['question_id_cache']))
	{
		if (($modSettings['question_id_cache'] = cache_get_data('verificationQuestionIds', 300)) == null)
		{
			$request = $smcFunc['db_query']('', '
				SELECT id_comment
				FROM {db_prefix}log_comments
				WHERE comment_type = {string:ver_test}',
				array(
					'ver_test' => 'ver_test',
				)
			);
			$modSettings['question_id_cache'] = array();
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$modSettings['question_id_cache'][] = $row['id_comment'];
			$smcFunc['db_free_result']($request);

			if (!empty($modSettings['cache_enable']))
				cache_put_data('verificationQuestionIds', $modSettings['question_id_cache'], 300);
		}
	}

	if (!isset($_SESSION[$verificationOptions['id'] . '_vv']))
		$_SESSION[$verificationOptions['id'] . '_vv'] = array();

	// Do we need to refresh the verification?
	if (!$do_test && (!empty($_SESSION[$verificationOptions['id'] . '_vv']['did_pass']) || empty($_SESSION[$verificationOptions['id'] . '_vv']['count']) || $_SESSION[$verificationOptions['id'] . '_vv']['count'] > 3) && empty($verificationOptions['dont_refresh']))
		$force_refresh = true;
	else
		$force_refresh = false;

	// This can also force a fresh, although unlikely.
	if (($thisVerification['show_visual'] && empty($_SESSION[$verificationOptions['id'] . '_vv']['code'])) || ($thisVerification['number_questions'] && empty($_SESSION[$verificationOptions['id'] . '_vv']['q'])))
		$force_refresh = true;

	$verification_errors = array();

	// Start with any testing.
	if ($do_test)
	{
		// This cannot happen!
		if (!isset($_SESSION[$verificationOptions['id'] . '_vv']['count']))
			fatal_lang_error('no_access');
		// ... nor this!
		if ($thisVerification['number_questions'] && (!isset($_SESSION[$verificationOptions['id'] . '_vv']['q']) || !isset($_REQUEST[$verificationOptions['id'] . '_vv']['q'])))
			fatal_lang_error('no_access');

		if ($thisVerification['show_visual'] && (empty($_REQUEST[$verificationOptions['id'] . '_vv']['code']) || empty($_SESSION[$verificationOptions['id'] . '_vv']['code']) || strtoupper($_REQUEST[$verificationOptions['id'] . '_vv']['code']) !== $_SESSION[$verificationOptions['id'] . '_vv']['code']))
			$verification_errors[] = 'wrong_verification_code';
		if ($thisVerification['number_questions'])
		{
			// Get the answers and see if they are all right!
			$request = $smcFunc['db_query']('', '
				SELECT id_comment, recipient_name AS answer
				FROM {db_prefix}log_comments
				WHERE comment_type = {string:ver_test}
					AND id_comment IN ({array_int:comment_ids})',
				array(
					'ver_test' => 'ver_test',
					'comment_ids' => $_SESSION[$verificationOptions['id'] . '_vv']['q'],
				)
			);
			$incorrectQuestions = array();
			while ($row = $smcFunc['db_fetch_assoc']($request))
			{
				if (empty($_REQUEST[$verificationOptions['id'] . '_vv']['q'][$row['id_comment']]) || trim($smcFunc['htmlspecialchars'](strtolower($_REQUEST[$verificationOptions['id'] . '_vv']['q'][$row['id_comment']]))) != strtolower($row['answer']))
					$incorrectQuestions[] = $row['id_comment'];
			}
			$smcFunc['db_free_result']($request);

			if (!empty($incorrectQuestions))
				$verification_errors[] = 'wrong_verification_answer';
		}
	}

	// Any errors means we refresh potentially.
	if (!empty($verification_errors))
	{
		if (empty($_SESSION[$verificationOptions['id'] . '_vv']['errors']))
			$_SESSION[$verificationOptions['id'] . '_vv']['errors'] = 0;
		// Too many errors?
		elseif ($_SESSION[$verificationOptions['id'] . '_vv']['errors'] > $thisVerification['max_errors'])
			$force_refresh = true;

		// Keep a track of these.
		$_SESSION[$verificationOptions['id'] . '_vv']['errors']++;
	}

	// Are we refreshing then?
	if ($force_refresh)
	{
		// Assume nothing went before.
		$_SESSION[$verificationOptions['id'] . '_vv']['count'] = 0;
		$_SESSION[$verificationOptions['id'] . '_vv']['errors'] = 0;
		$_SESSION[$verificationOptions['id'] . '_vv']['did_pass'] = false;
		$_SESSION[$verificationOptions['id'] . '_vv']['q'] = array();

		// Generating a new image.
		if ($thisVerification['show_visual'])
		{
			// Are we overriding the range?
			$character_range = !empty($verificationOptions['override_range']) ? $verificationOptions['override_range'] : $context['standard_captcha_range'];

			$_SESSION[$verificationOptions['id'] . '_vv']['code'] = '';
			for ($i = 0; $i < 5; $i++)
				$_SESSION[$verificationOptions['id'] . '_vv']['code'] .= $character_range[array_rand($character_range)];
		}

		// Getting some new questions?
		if ($thisVerification['number_questions'])
		{
			// Pick some random IDs
			$questionIDs = array();
			if ($thisVerification['number_questions'] == 1)
				$questionIDs[] = $modSettings['question_id_cache'][array_rand($modSettings['question_id_cache'], $thisVerification['number_questions'])];
			else
				foreach (array_rand($modSettings['question_id_cache'], $thisVerification['number_questions']) as $index)
					$questionIDs[] = $modSettings['question_id_cache'][$index];
		}
	}
	else
	{
		// Same questions as before.
		$questionIDs = !empty($_SESSION[$verificationOptions['id'] . '_vv']['q']) ? $_SESSION[$verificationOptions['id'] . '_vv']['q'] : array();
		$thisVerification['text_value'] = !empty($_REQUEST[$verificationOptions['id'] . '_vv']['code']) ? $smcFunc['htmlspecialchars']($_REQUEST[$verificationOptions['id'] . '_vv']['code']) : '';
	}

	// Have we got some questions to load?
	if (!empty($questionIDs))
	{
		$request = $smcFunc['db_query']('', '
			SELECT id_comment, body AS question
			FROM {db_prefix}log_comments
			WHERE comment_type = {string:ver_test}
				AND id_comment IN ({array_int:comment_ids})',
			array(
				'ver_test' => 'ver_test',
				'comment_ids' => $questionIDs,
			)
		);
		$_SESSION[$verificationOptions['id'] . '_vv']['q'] = array();
		while ($row = $smcFunc['db_fetch_assoc']($request))
		{
			$thisVerification['questions'][] = array(
				'id' => $row['id_comment'],
				'q' => parse_bbc($row['question']),
				'is_error' => !empty($incorrectQuestions) && in_array($row['id_comment'], $incorrectQuestions),
				// Remember a previous submission?
				'a' => isset($_REQUEST[$verificationOptions['id'] . '_vv'], $_REQUEST[$verificationOptions['id'] . '_vv']['q'], $_REQUEST[$verificationOptions['id'] . '_vv']['q'][$row['id_comment']]) ? $smcFunc['htmlspecialchars']($_REQUEST[$verificationOptions['id'] . '_vv']['q'][$row['id_comment']]) : '',
			);
			$_SESSION[$verificationOptions['id'] . '_vv']['q'][] = $row['id_comment'];
		}
		$smcFunc['db_free_result']($request);
	}

	$_SESSION[$verificationOptions['id'] . '_vv']['count'] = empty($_SESSION[$verificationOptions['id'] . '_vv']['count']) ? 1 : $_SESSION[$verificationOptions['id'] . '_vv']['count'] + 1;

	// Return errors if we have them.
	if (!empty($verification_errors))
		return $verification_errors;
	// If we had a test that one, make a note.
	elseif ($do_test)
		$_SESSION[$verificationOptions['id'] . '_vv']['did_pass'] = true;

	// Say that everything went well chaps.
	return true;
}

// This keeps track of all registered handling functions for auto suggest functionality and passes execution to them.
function AutoSuggestHandler($checkRegistered = null)
{
	global $context;

	// These are all registered types.
	$searchTypes = array(
		'member' => 'Member',
	);

	// If we're just checking the callback function is registered return true or false.
	if ($checkRegistered != null)
		return isset($searchTypes[$checkRegistered]) && function_exists('AutoSuggest_Search_' . $checkRegistered);

	checkSession('get');
	loadTemplate('Xml');

	// Any parameters?
	$context['search_param'] = isset($_REQUEST['search_param']) ? unserialize(base64_decode($_REQUEST['search_param'])) : array();

	if (isset($_REQUEST['suggest_type'], $_REQUEST['search']) && isset($searchTypes[$_REQUEST['suggest_type']]))
	{
		$function = 'AutoSuggest_Search_' . $searchTypes[$_REQUEST['suggest_type']];
		$context['sub_template'] = 'generic_xml';
		$context['xml_data'] = $function();
	}
}

// Search for a member - by realName or memberName by default.
function AutoSuggest_Search_Member()
{
	global $user_info, $txt, $smcFunc;

	$_REQUEST['search'] = trim($smcFunc['strtolower']($_REQUEST['search'])) . '*';
	$_REQUEST['search'] = strtr($_REQUEST['search'], array('%' => '\%', '_' => '\_', '*' => '%', '?' => '_', '&#038;' => '&amp;'));

	// Find the member.
	$request = $smcFunc['db_query']('', '
		SELECT id_member, real_name
		FROM {db_prefix}members
		WHERE real_name LIKE {string:search}' . (!empty($context['search_param']['buddies']) ? '
			AND id_member IN ({array_int:buddy_list})' : '') . '
			AND is_activated IN (1, 11)
		LIMIT ' . (strlen($_REQUEST['search']) <= 2 ? '100' : '800'),
		array(
			'buddy_list' => $user_info['buddies'],
			'search' => $_REQUEST['search'],
		)
	);
	$xml_data = array(
		'members' => array(
			'identifier' => 'member',
			'children' => array(),
		),
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		if (function_exists('iconv'))
		{
			$utf8 = iconv($txt['lang_character_set'], 'UTF-8', $row['real_name']);
			if ($utf8)
				$row['real_name'] = $utf8;
		}

		if (preg_match('~&#\d+;~', $row['real_name']) != 0)
		{
			$fixchar = create_function('$n', '
				if ($n < 128)
					return chr($n);
				elseif ($n < 2048)
					return chr(192 | $n >> 6) . chr(128 | $n & 63);
				elseif ($n < 65536)
					return chr(224 | $n >> 12) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);
				else
					return chr(240 | $n >> 18) . chr(128 | $n >> 12 & 63) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);');

			$row['real_name'] = preg_replace('~&#(\d+);~e', '$fixchar(\'$1\')', $row['real_name']);
		}

		$row['real_name'] = strtr($row['real_name'], array('&amp;' => '&#038;', '&lt;' => '&#060;', '&gt;' => '&#062;', '&quot;' => '&#034;'));

		$xml_data['members']['children'][] = array(
			'attributes' => array(
				'id' => $row['id_member'],
			),
			'value' => $row['real_name'],
		);
	}
	$smcFunc['db_free_result']($request);

	return $xml_data;
}

?>