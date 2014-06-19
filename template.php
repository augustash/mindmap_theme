<?php

/**
 * Implements hook_fett_icons_alter().
 */
function boushh_fett_icons_alter(&$icons){
  $icons['add'] = 'plus';
  $icons['apply'] = 'save';
  $icons['preview'] = 'eye';
  $icons['save'] = 'save';
  $icons['cancel'] = 'undo';
  $icons['rearrange'] = 'bars';
  $icons['list'] = 'list';
  $icons['disable'] = 'ban';
  $icons['remove'] = 'ban';
  $icons['clone'] = 'copy';
  $icons['export'] = 'external-link';
  $icons['enable'] = 'check-circle-o';
  $icons['enable and set default'] = 'check-circle';
  $icons['set default'] = 'check-circle';
  $icons['manage fields'] = 'tasks';
  $icons['update'] = 'arrow-up';
}

/**
 * Implements hook_element_info_alter().
 */
function boushh_element_info_alter(&$type){
  $type['actions']['#process'][] = 'boushh_form_process_actions';
}

/**
 * Processes a form actions container element.
 *
 * @param $element
 *   An associative array containing the properties and children of the
 *   form actions container.
 * @param $form_state
 *   The $form_state array for the form this element belongs to.
 *
 * @return
 *   The processed element.
 */
function boushh_form_process_actions($element, &$form_state) {
  foreach (element_children($element) as $key) {
    $item = &$element[$key];
    if(isset($item['#type']) && in_array($item['#type'], array('submit','button'))){
      $item['#attributes']['class'][] = 'medium';
      if($item['#value'] == 'Save'){
        $item['#attributes']['class'][] = 'primary';
      }
    }
  }
  return $element;
}

/**
 * Implements template_preprocess_html().
 *
 */
function boushh_preprocess_html(&$vars) {
  // Add theme class to body
  $vars['classes_array'][] = 'boushh';

  // Add Open Sans
  drupal_add_css('@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic,700italic,800italic);',$option['type'] = 'inline');
}


/**
 * Implements template_preprocess_page
 *
 */
function boushh_preprocess_page(&$vars) {

  $vars['ops'] = array();
  $bar = NULL;
  if(!empty($vars['action_links'])){
    $items = $vars['action_links'];
    foreach($items as &$item){
      $item['#theme'] = $item['#theme'] . '__ops';
    }
    $bar['right'] = $items;
    $bar['right']['#prefix'] = '<ul class="right">';
    $bar['right']['#suffix'] = '</ul>';
  }
  $tabs = NULL;
  if(!empty($vars['tabs']['#primary'])){
    $items = $vars['tabs']['#primary'];
    $combined = array();
    foreach($items as &$item){
      $item['#theme'] = $item['#theme'] . '__ops';
      $children = array();
      if(!empty($item['#active'])){
        if(!empty($vars['tabs']['#secondary'])){
          $item['#link']['field_suffix'] = ' <i class="fa fa-caret-right"></i>';
          $secondary_items = $vars['tabs']['#secondary'];
          $last = key( array_slice( $secondary_items, -1, 1, TRUE ) );
          foreach($secondary_items as $key => &$child_item){
            $child_item['#theme'] = $child_item['#theme'] . '__ops';
            $child_item['#link']['attributes']['class'][] = 'secondary';
            // if($key == 0) $item['#link']['prefix'] = '<li class="divider"></li>';
            // if($key == $last) $child_item['#link']['suffix'] = '<li class="divider"></li>';
            // $item['#link']['localized_options']['attributes']['class'][] = 'button';
            $children[] = $child_item;
          }
        }
      }
      $combined[] = $item;
      if(!empty($children)) $combined = array_merge($combined, $children);
    }
    $tabs['primary'] = $combined;
  }
  // if(!empty($vars['tabs']['#secondary'])){
  //   $items = $vars['tabs']['#secondary'];
  //   $last = key( array_slice( $items, -1, 1, TRUE ) );
  //   foreach($items as $key => &$item){
  //     $item['#theme'] = $item['#theme'] . '__ops';
  //     // $item['#link']['attributes']['class'][] = 'has-form';
  //     if($key == 0) $item['#link']['prefix'] = '<li class="divider"></li>';
  //     if($key == $last) $item['#link']['suffix'] = '<li class="divider"></li>';
  //     // $item['#link']['localized_options']['attributes']['class'][] = 'button';
  //   }
  //   $tabs['secondary'] = $items;
  // }
  if(!empty($tabs)){
    $bar['left']['#prefix'] = '<ul class="left">';
    $bar['left']['#suffix'] = '</ul>';
    $bar['left'] += $tabs;
  }
  if(!empty($bar)){

    $vars['ops']['#prefix'] = '<nav class="ops-bar" data-topbar>';
    $vars['ops']['#suffix'] = '</nav>';

    $items = array();
    $vars['ops']['title'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
      '#attributes' => array('class' => array('title-area')),
    );

    $vars['ops']['bar']['#prefix'] = '<section class="ops-bar-section">';
    $vars['ops']['bar']['#suffix'] = '</section>';
    $vars['ops']['bar'] += $bar;
  }
}


/**
 * Implements template_preprocess_node
 *
 */
//function boushh_preprocess_node(&$vars) {
//}


/**
 * Implements hook_preprocess_block()
 */
//function boushh_preprocess_block(&$vars) {
//}


//function boushh_preprocess_views_view(&$vars) {
//}


/**
 * Implements template_preprocess_panels_pane().
 *
 */
//function boushh_preprocess_panels_pane(&$vars) {
//}


/**
 * Implements template_preprocess_views_views_fields().
 *
 */
//function boushh_preprocess_views_view_fields(&$vars) {
//}


/**
 * Implements theme_form_element_label()
 * Use foundation tooltips
 */
//function boushh_form_element_label($vars) {
//}


/**
 * Implements hook_preprocess_button().
 */
//function boushh_preprocess_button(&$vars) {
//}


/**
 * Implements hook_form_alter()
 * Example of using foundation sexy buttons
 */
//function boushh_form_alter(&$form, &$form_state, $form_id) {
//  // Sexy submit buttons
//  if (!empty($form['actions']) && !empty($form['actions']['submit'])) {
//    $form['actions']['submit']['#attributes'] = array('class' => array('primary', 'button', 'radius'));
//  }
//}

// Sexy preview buttons
//function boushh_form_comment_form_alter(&$form, &$form_state) {
//  $form['actions']['preview']['#attributes']['class'][] = array('class' => array('secondary', 'button', 'radius'));
//}


/**
 * Implements template_preprocess_panels_pane().
 */
// function zurb_foundation_preprocess_panels_pane(&$vars) {
// }


/**
* Implements template_preprocess_views_views_fields().
*/
// function THEMENAME_preprocess_views_view_fields(&$vars) {
// }


/**
 * Implements hook_css_alter().
 */
//function boushh_css_alter(&$css) {
//  // Always remove base theme CSS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($css as $path => $values) {
//    if(strpos($path, $theme_path) === 0) {
//      unset($css[$path]);
//    }
//  }
//}


/**
 * Implements hook_js_alter().
 */
//function boushh_js_alter(&$js) {
//  // Always remove base theme JS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($js as $path => $values) {
//    if(strpos($path, $theme_path) === 0) {
//      unset($js[$path]);
//    }
//  }
//}

/**
 * Implements theme_menu_local_action().
 */
function boushh_menu_local_action($vars) {
  $link = $vars['element']['#link'];

  $output = '<li>';
  if (isset($link['href'])) {
    // Add section tab styling
    // $link['localized_options']['attributes']['class'] = array('tiny', 'button', 'secondary');

    // Add Font Awesome Icon
    fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
    $link_text = $link['title'];

    $output .= l($link_text, $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Implements theme_menu_local_action().
 */
function boushh_menu_local_action__ops($vars) {
  $link = $vars['element']['#link'];

  $output = '<li>';
  if (isset($link['href'])) {
    // Add section tab styling
    // $link['localized_options']['attributes']['class'] = array('button');

    // Add Font Awesome Icon
    fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
    $link_text = $link['title'];

    $output .= l($link_text, $link['href'], isset($link['localized_options']) ? $link['localized_options'] : array());
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $link['title'];
  }
  else {
    $output .= check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Implements theme_menu_local_task().
 */
function fett_menu_local_task__ops(&$vars) {
  $link = $vars['element']['#link'];
  $link['attributes'] = !empty($link['attributes']) ? $link['attributes'] : array();
  if(!empty($vars['element']['#active'])){
    $link['attributes']['class'][] = 'active';
  }

  // Add section tab styling
  // $link['localized_options']['attributes']['class'] = array('tiny', 'button', 'secondary');

  // Add Font Awesome Icon
  fett_icon_link($link['title'], $link['localized_options'], TRUE, TRUE);
  $link_text = $link['title'];

  if (!empty($vars['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }

    $link['localized_options']['attributes']['class'][] = 'disabled';
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  $output = '';
  if(!empty($link['prefix'])) $output .= $link['prefix'];
  $output .= '<li' . drupal_attributes($link['attributes']) . '>';
  if(!empty($link['field_prefix'])) $link_text = $link['field_prefix'] . $link_text;
  if(!empty($link['field_suffix'])) $link_text .= $link['field_suffix'];
  $output .= l($link_text, $link['href'], $link['localized_options']);
  $output .= "</li>\n";
  if(!empty($link['suffix'])) $output .= $link['suffix'];
  return  $output;
}

/**
 * Implements theme_links().
 */
function boushh_links($vars) {
  $links = $vars['links'];
  $attributes = $vars['attributes'];
  $heading = $vars['heading'];
  global $language_url;
  $output = '';

  if (count($links) > 0) {
    $output = '';

    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,

          // Set the default level of the heading.
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    // Add Foundation inline-list class if necessary.
    if(boushh_class_exists($attributes, 'inline')){
      $attributes['class'][] = 'inline-list';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page())) && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {// Add Font Awesome Icon
        fett_icon_link($link['title'], $link, TRUE, TRUE);
        $link_text = $link['title'];
        // Pass in $link as $options, they share the same keys.
        $output .= l($link_text, $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

// /**
//  * Implements theme_ctools_dropdown().
//  */
// function boushh_ctools_dropdown($vars) {
//   // dsm($vars);
//   // dsm('CTOOLS DROPDOWN');
//   // Provide a unique identifier for every dropdown on the page.
//   static $id = 0;
//   $id++;

//   $class = 'ctools-dropdown-no-js ctools-dropdown' . ($vars['class'] ? (' ' . $vars['class']) : '');

//   ctools_add_js('dropdown');
//   ctools_add_css('dropdown');

//   $output = '';

//   $output .= '<div class="' . $class . '" id="ctools-dropdown-' . $id . '">';
//   $output .= '<div class="ctools-dropdown-link-wrapper">';
//   if ($vars['image']) {
//     $output .= '<a href="#" class="ctools-dropdown-link ctools-dropdown-image-link">' . $vars['title'] . '</a>';
//   }
//   else {
//     $output .= '<a href="#" class="ctools-dropdown-link ctools-dropdown-text-link">' . check_plain($vars['title']) . '</a>';
//   }

//   $output .= '</div>'; // wrapper
//   $output .= '<div class="ctools-dropdown-container-wrapper">';
//   $output .= '<div class="ctools-dropdown-container">';
//   $output .= theme_links(array('links' => $vars['links'], 'attributes' => array(), 'heading' => ''));
//   $output .= '</div>'; // container
//   $output .= '</div>'; // container wrapper
//   $output .= '</div>'; // dropdown
//   return $output;
// }

// function boushh_links__ctools_links($vars) {
//   dsm($vars);
// }

/**
 * Implements theme_links__ctools_dropbutton
 */
function boushh_links__ctools_dropbutton($vars) {
  fett_foundation_add_js('foundation.dropdown.js');

  // Check to see if the number of links is greater than 1;
  // otherwise just treat this like a button.
  if (!empty($vars['links'])) {

    $is_drop_button = (count($vars['links']) > 1);

    // Provide a unique identifier for every button on the page.
    static $id = 0;
    $id++;

    // Add needed files
    if ($is_drop_button) {
      ctools_add_js('dropbutton');
      ctools_add_css('dropbutton');
    }
    ctools_add_css('button');

    // Wrapping div
    $class = 'ctools-no-js';
    $class .= ($is_drop_button) ? ' ctools-dropbutton' : '';
    $class .= ' ctools-button';
    if (!empty($vars['class'])) {
      $class .= ($vars['class']) ? (' ' . implode(' ', $vars['class'])) : '';
    }

    $output = '';

    $output .= '<div class="' . $class . '" id="ctools-button-' . $id . '">';

    // Add a twisty if this is a dropbutton
    if ($is_drop_button) {
      $vars['title'] = ($vars['title'] ? check_plain($vars['title']) : t('open'));

      $output .= '<div class="ctools-link">';
      if ($vars['image']) {
        $output .= '<a href="#" class="ctools-twisty ctools-image">' . $vars['title'] . '</a>';
      }
      else {
        $output .= '<a href="#" class="ctools-twisty ctools-text">' . $vars['title'] . '</a>';
      }
      $output .= '</div>'; // ctools-link
    }

    // The button content
    $output .= '<div class="ctools-content">';

    // Check for attributes. theme_links expects an array().
    $vars['attributes'] = (!empty($vars['attributes'])) ? $vars['attributes'] : array();

    // Remove the inline and links classes from links if they exist.
    // These classes are added and styled by Drupal core and mess up the default
    // styling of any link list.
    if (!empty($vars['attributes']['class'])) {
      $classes = $vars['attributes']['class'];
      foreach ($classes as $key => $class) {
        if ($class === 'inline' || $class === 'links') {
          unset($vars['attributes']['class'][$key]);
        }
      }
    }

    // Call theme_links to render the list of links.
    // $output .= theme_links(array('links' => $vars['links'], 'attributes' => $vars['attributes'], 'heading' => ''));
    $output .= theme('links', array('links' => $vars['links'], 'attributes' => $vars['attributes'], 'heading' => ''));
    $output .= '</div>'; // ctools-content
    $output .= '</div>'; // ctools-dropbutton
    return $output;
  }
  else {
    return '';
  }
}

/**
 * Implements theme_button().
 */
function boushh_button($vars) {
  $element = $vars['element'];
  $label = $element['#value'];
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  if(boushh_class_exists($element['#attributes'], 'button')){
    $element['#attributes']['class'][] = 'button';
  }

  if(!boushh_class_exists($element['#attributes'], array('tiny','small','medium','large'))){
    $element['#attributes']['class'][] = 'tiny';
  }

  if(!boushh_class_exists($element['#attributes'], array('primary','secondary','success','alert'))){
    $element['#attributes']['class'][] = 'secondary';
  }

  // Prepare input whitelist - added to ensure ajax functions don't break
  $whitelist = _fett_element_whitelist();

  if (isset($element['#id']) && (in_array($element['#id'], $whitelist)) || preg_match('/^edit-displays-/', $element['#id'])) {
    return '<input' . drupal_attributes($element['#attributes']) . ">\n"; // This line break adds inherent margin between multiple buttons
  }
  else {
    // Add Font Awesome Icon
    $temp = array();
    fett_icon_link($label, $temp, FALSE);
    return '<button' . drupal_attributes($element['#attributes']) . '>'. $label ."</button>\n"; // This line break adds inherent margin between multiple buttons
  }
}

/**
 * Implements theme_form_element().
 */
function boushh_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  if(isset($element['#field_prefix']) || isset($element['#field_suffix'])){
    $attributes['class'][] = 'field-inline';
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

////////////////////////////////////////////////////////////////////////////////
// Utilities
////////////////////////////////////////////////////////////////////////////////

/**
 * Check to see if class exists
 */
function boushh_class_exists(&$attributes, $class = array()){  // Check for attributes. theme_links expects an array().
  $attributes = (!empty($attributes)) ? $attributes : array();
  if (!empty($attributes['class'])) {
    $attributes['class'] = is_array($attributes['class']) ? $attributes['class'] : array($attributes['class']);
    foreach($attributes['class'] as $key => $c) {
      // dsm($class);
      $class = !is_array($class) ? array($class) : $class;
      foreach($class as $cc){
        if(preg_match('/'.preg_quote($cc).'/i', $c)){
          return TRUE;
        }
      }
    }
  }
  return FALSE;
}
