<?php

/**
 * @file
 * File which contains theme overrides for the Deco theme.
 */


/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
	$vars['body_classes'] = isset($vars['body_classes']) ? $vars['body_classes'] : '';
	
	// variable to see if we have a triple sidebars and are not on block admin page
	$vars['sidebar_triple'] = FALSE;
	
	// add variable for block admin page
	$vars['block_admin'] = FALSE;
	
	if (arg(2) == 'block' && arg(3) == FALSE) {
		$vars['block_admin'] = TRUE;
		_deco_alert_layout($vars);
		$vars['body_classes'] .= ' block-admin';
	}
	
	else {
		
		// convert secondary right sidebar to right sidebar if there's no right sidebar
		if ($vars['sidebar_right_sec'] && empty($vars['sidebar_right'])) {
			$vars['sidebar_right'] = $vars['sidebar_right_sec'];
			$vars['sidebar_right_sec'] = '';
		}
		
		// set a class on the body to allow easier css themeing based on the layout type
  	if ($vars['sidebar_right'] && $vars['sidebar_right_sec'] && $vars['sidebar_left']) {
    	$vars['body_classes'] .= ' sidebar-triple';
			$vars['sidebar_triple'] = TRUE;
		}
		elseif ($vars['sidebar_left'] && $vars['sidebar_right']) {
  		$vars['body_classes'] .= ' sidebar-double';
		}
		elseif ($vars['sidebar_right'] && $vars['sidebar_right_sec']) {
	  	$vars['body_classes'] .= ' sidebar-right-double';
		}
  	elseif ($vars['sidebar_left']) {
  		$vars['body_classes'] .= ' sidebar-left';
		}
  	elseif ($vars['sidebar_right'] || $vars['sidebar_right_sec']) {
  		$vars['body_classes'] .= ' sidebar-right';
		}

		// add additional rightbar body class to reduce css to refer to right sidebars
		if ($vars['sidebar_right']) {
			$vars['body_classes'] .= ' rightbar';
		}
	}
	
	// set variables for the logo and slogan
	$site_fields = array();
  if ($vars['site_name']) {
    $site_fields[] = check_plain($vars['site_name']);
  }
  if ($vars['site_slogan']) {
    $site_fields[] = '- '.check_plain($vars['site_slogan']);
  }
  
	$vars['site_title'] = implode(' ', $site_fields);

	if (isset($site_fields[0])) {
  	$site_fields[0] = '<span class="site-name">'. $site_fields[0] .'</span>';
	}
	if (isset($site_fields[1])) {
		$site_fields[1] = '<span class="site-slogan">'. $site_fields[1] .'</span>';
	}
	
  $vars['site_title_html'] = implode(' ', $site_fields);

	// convert primary links to lowercase and secondary links to uppercase
	if ($vars['primary_links']) {
		foreach ($vars['primary_links'] as $key => $link) {
			$vars['primary_links'][$key]['title'] = strtolower($link['title']);
		}
	}
	if ($vars['secondary_links']) {
		foreach ($vars['secondary_links'] as $key => $link) {
			$vars['secondary_links'][$key]['title'] = strtoupper($link['title']);
		}
	}
}

/**
 * Alert the user when the layout is changed based on the used regions. 
 *
 * @param $regions
 *   An associative array containing the regions.
 */
function _deco_alert_layout($regions) {
	if (user_access('administer blocks')) {
		// remove the block indicators first
		$sidebars = array(
			'sidebar_right_sec' => $regions['sidebar_right_sec'], 
			'sidebar_right'     => $regions['sidebar_right'], 
			'sidebar_left'      => $regions['sidebar_left']
		);
	
		foreach ($sidebars as $k => $v) {
			$sidebars[$k] = preg_replace('/(\<div class="block-region"\>)(.*)(\<\/div\>)/', '', $v);
		}
	
		// warn the user that the secondary right sidebar will look like a regular right sidebar
		if ($sidebars['sidebar_right_sec'] && empty($sidebars['sidebar_right'])) {
			drupal_set_message(t('Warning: if you add blocks to the <em>secondary right sidebar</em> and leave the <em>right sidebar</em> empty, the <em>secondary right
			sidebar</em> will be rendered as a regular <em>right sidebar</em>.'));
		}
		// warn the user that the three sidebars will look like three equal columns
		elseif ($sidebars['sidebar_right'] && $sidebars['sidebar_right_sec'] && $sidebars['sidebar_left']) {
			drupal_set_message(t('Warning: if you add blocks to all three sidebars they will be rendered as three equal columns above the content.'));
		}
	}
}

/**
 * Generates the html to be rendered in the content area. Prevents duplication in the page template file
 */
function phptemplate_render_content($content, $tabs, $title, $help, $show_messages, $messages, $feed_icons, $body_classes) {
	
	$in_node = (strstr($body_classes, 'page-node') ? TRUE : FALSE);
	
	$output = '';
	$output .= ((!empty($title)) ? '<h2 class="content-title">'.$title.'</h2>' : '');
	$tabs = menu_primary_local_tasks();
	
	$output .= ($tabs ? phptemplate_menu_local_tasks('<ul class="tabs primary">'.$tabs.'</ul>') : '');
	
	$secondary_tabs = menu_secondary_local_tasks();
	
	$output .= ($secondary_tabs ? phptemplate_menu_secondary_local_tasks('<ul class="tabs secondary">'.$secondary_tabs.'</ul>') : '');
	$output .= ($help ? '<div class="help">'.$help.'</div>' : '');
	$output .= (($show_messages && $messages) ? $messages : '');
  $output .= $content;
	$output .= ($feed_icons ? $feed_icons : '');

	return $output;
}

/**
 * Format a group of form items.
 * Add HTML hooks for advanced styling
 *
 * @param $element
 *   An associative array containing the properties of the element.
 *   Properties used: attributes, title, value, description, children, collapsible, collapsed
 * @return
 *   A themed HTML string representing the form item group.
 */
function phptemplate_fieldset($element) {
  if ($element['#collapsible']) {
    drupal_add_js('misc/collapse.js');

    if (!isset($element['#attributes']['class'])) {
      $element['#attributes']['class'] = '';
    }

    $element['#attributes']['class'] .= ' collapsible';
    if ($element['#collapsed']) {
     $element['#attributes']['class'] .= ' collapsed';
    }
  }

  return '<fieldset'. drupal_attributes($element['#attributes']) .'>'. ($element['#title'] ? '<legend>'. $element['#title'] .'</legend>' : '') .'<div class="top"><div class="bottom"><div class="bottom-ornament">'. (isset($element['#description']) && $element['#description'] ? '<div class="description">'. $element['#description'] .'</div>' : '') . (!empty($element['#children']) ? $element['#children'] : '') . $element['#value'] ."</div></div></div></fieldset>\n";
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks($tasks = '') {
	$output = '';
	
  if (!empty($tasks)) {
		$output = "\n<div class=\"content-bar clear-block\"><div class=\"left\">\n". $tasks ."\n</div></div>\n";
	}

  return $output;
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs.
 *
 * @ingroup themeable
 */
function phptemplate_menu_secondary_local_tasks($tasks = '') {
	$output = '';
	
  if (!empty($tasks)) {
		$output = "\n<div class=\"content-bar-indented\"><div class=\"content-bar clear-block\"><div class=\"left\">\n". $tasks ."\n</div></div></div>\n";
	}

  return $output;
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode('   ', $breadcrumb) .'</div>';
  }
}

/**
 * 	Format a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to retrieve a pager control so that users can view  
 * other results. Format a list of nearby pages with additional query results.
 * 
 * Adds HTML hooks for making the pager appear in a horizontal bar
 */
function phptemplate_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
	$output = theme_pager($tags, $limit, $element, $parameters, $quantity);
	
	if (!empty($output)) {
		$output = '<div class="content-bar"><div class="left">'.$output.'</div></div>';
	}
	return $output;
}


function phptemplate_comment_submitted($comment) {
  return t('!username   !datetime',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => '<span class="date">'.format_date($comment->timestamp).'</span>'
    ));
}

function phptemplate_node_submitted($node) {
  return t('!username   !datetime',
    array(
      '!username' => theme('username', $node),
      '!datetime' => '<span class="date">'.format_date($node->created).'</span>'
    ));
}


// Override the ending l() function to allow html in the pager links (thanks Kaaskop & Swentel)  :
function vwr_pager_link($variables) {
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }

  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('First') => t('Go to first page'),
        t('Prev') => t('Go to previous page'),
        t('Next') => t('Go to next page'),
        t('Last') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  return l($text, $_GET['q'], array('attributes' => $attributes, 'query' => $query));
}


/**
 * Returns HTML for a query pager.
 *
 * Menu callbacks that display paged query results should call theme('pager') to
 * retrieve a pager control so that users can view other results. Format a list
 * of nearby pages with additional query results.
 *
 * @param $variables
 *   An associative array containing:
 *   - tags: An array of labels for the controls in the pager.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *   - quantity: The number of pages in the list.
 *
 * @ingroup themeable
 */
function vwr_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  $quantity = 4;
  global $pager_page_array, $pager_total;
  
 

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.
  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('First')),  'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('Prev')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
 //$li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] :  t('Prev')), $limit, $element, 1, $parameters);
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] :  t('Next')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] :  t('Last')), 'element' => $element, 'parameters' => $parameters));
  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('old'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('prev'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      /*if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '...',
        );
      }*/
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('num'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('selected'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('num'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
     /* if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '...',
        );
      }*/
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('')),
    ));
  }
}

/**
 * Returns HTML for the "first page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vwr_pager_first($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  global $pager_page_array;
  $output = '';
  $theme_path = base_path().drupal_get_path('theme', 'vwr');
  // $text = array('<img>' =>'older.jpg');
  // If we are anywhere but the first page
  if ($pager_page_array[$element] > 0) {
    $output = theme('pager_link', array('text' => $text, 'page_new' => pager_load_array(0, $element, $pager_page_array), 'element' => $element, 'parameters' => $parameters));
  }

  return $output;
}

/**
 * Returns HTML for the "previous page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move backward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vwr_pager_previous($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $interval = $variables['interval'];
  $parameters = $variables['parameters'];
  global $pager_page_array;
  $output = '';
  $theme_path = base_path().drupal_get_path('theme', 'vwr');
 // $text = "<img src='".$theme_path."/images/previous.jpg'>";
	
  // If we are anywhere but the first page
  if ($pager_page_array[$element] > 0) {
    $page_new = pager_load_array($pager_page_array[$element] - $interval, $element, $pager_page_array);

    // If the previous page is the first page, mark the link as such.
    if ($page_new[$element] == 0) {
      $output = theme('pager_first', array('text' => $text, 'element' => $element, 'parameters' => $parameters));
    }
    // The previous page is not the first page.
    else {
      $output = theme('pager_link', array('text' => $text, 'page_new' => $page_new, 'element' => $element, 'parameters' => $parameters));
    }
  }

  return $output;
}

/**
 * Returns HTML for the "next page" link in a query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - interval: The number of pages to move forward when the link is clicked.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vwr_pager_next($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $interval = $variables['interval'];
  $parameters = $variables['parameters'];
  $theme_path = base_path().drupal_get_path('theme', 'vwr');
  //$text = "<img src=".$theme_path."/images/next.jpg>";
  global $pager_page_array, $pager_total;
  $output = '';
  // If we are anywhere but the last page
  if ($pager_page_array[$element] < ($pager_total[$element] - 1)) {
    $page_new = pager_load_array($pager_page_array[$element] + $interval, $element, $pager_page_array);
    // If the next page is the last page, mark the link as such.
    if ($page_new[$element] == ($pager_total[$element] - 1)) {
      $output = theme('pager_last', array('text' => $text, 'element' => $element, 'parameters' => $parameters));
    }
    // The next page is not the last page.
    else {
      $output = theme('pager_link', array('text' => $text, 'page_new' => $page_new, 'element' => $element, 'parameters' => $parameters));
    }
  }

  return $output;
}

/**
 * Returns HTML for the "last page" link in query pager.
 *
 * @param $variables
 *   An associative array containing:
 *   - text: The name (or image) of the link.
 *   - element: An optional integer to distinguish between multiple pagers on
 *     one page.
 *   - parameters: An associative array of query string parameters to append to
 *     the pager links.
 *
 * @ingroup themeable
 */
function vwr_pager_last($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $theme_path = base_path().drupal_get_path('theme', 'vwr');
 // $text = "<img src='".$theme_path."/images/last.jpg'>";
  global $pager_page_array, $pager_total;
  $output = '';

  // If we are anywhere but the last page
  if ($pager_page_array[$element] < ($pager_total[$element] - 1)) {
    $output = theme('pager_link', array('text' => $text, 'page_new' => pager_load_array($pager_total[$element] - 1, $element, $pager_page_array), 'element' => $element, 'parameters' => $parameters));
  }

  return $output;
}
function vwr_preprocess_node(&$vars) {
  if (node_access("update", $vars['node']) === TRUE) {
    $vars['edit_link']['#markup'] = l(t('Edit'), 'node/' . $vars['nid'] . '/edit');
  }
}

/* function vwr_preprocess_reg_form(&$variables) {
  $variables['form'] = $variables[''];
  $form['captcha'] = array(
  '#type' => 'captcha',
  '#captcha_type' => 'image_captcha/Image',&& is_null(arg(1))
); */

function vwr_preprocess_page(&$vars)
{
	$vars['cookie_options'] = array (
		'expires' => 0, 
		'path' => '/', 
		'domain' => null, // leading dot for compatibility or use subdomain
		'secure' => false,     // or set true for other env
		'httponly' => true,    // or false
		'samesite' => 'Strict' // None || Lax  || Strict
	);
}

/**
* Implements hook_html_head_alter().
*/
function vwr_html_head_alter(&$head_elements) {
  // Remove Drupal generator meta tag.
  // Use this if you want to remove the Drupal 7 Generator meta tag.
  if (isset($head_elements['system_meta_generator'])) {
    unset($head_elements['system_meta_generator']);
  }
}