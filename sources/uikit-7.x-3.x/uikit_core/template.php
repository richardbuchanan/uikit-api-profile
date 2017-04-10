<?php

/**
 * @file
 * Conditional logic and data processing for the UIkit theme.
 */

// Define constants we can reuse throughout the theme.
define('UIKIT_LIBRARY_VERSION', '3.0.0-beta.20');
define('UIKIT_JQUERY_VERSION', '2.1.4');
define('UIKIT_JQUERY_MIGRATE_VERSION', '1.4.1');

/**
 * Loads a UIkit include file.
 *
 * This function essentially does the same as Drupal core's
 * module_load_include() function, except targeting theme include files. It also
 * allows you to place the include files in a sub-directory of the theme for
 * better organization.
 *
 * Examples:
 * @code
 *   // Load includes/uikit_subtheme.admin.inc from the node module.
 *   uikit_load_include('inc', 'uikit_subtheme', 'uikit_subtheme.admin', 'includes');
 *   // Load preprocess.inc from the uikit_subtheme theme.
 *   uikit_load_include('inc', 'uikit_subtheme', 'preprocess');
 * @endcode
 *
 * Do not use this function in a global context since it requires Drupal to be
 * fully bootstrapped, use require_once DRUPAL_ROOT . '/path/file' instead.
 *
 * @param string $type
 *   The include file's type (file extension).
 * @param string $theme
 *   The theme to which the include file belongs.
 * @param string $name
 *   (optional) The base file name (without the $type extension). If omitted,
 *   $theme is used; i.e., resulting in "$theme.$type" by default.
 * @param string $sub_directory
 *   (optional) The sub-directory to which the include file resides.
 *
 * @return string
 *   The name of the included file, if successful; FALSE otherwise.
 */
function uikit_load_include($type, $theme, $name = NULL, $sub_directory = '') {
  static $files = array();

  if (isset($sub_directory)) {
    $sub_directory = '/' . $sub_directory;
  }

  if (!isset($name)) {
    $name = $theme;
  }

  $key = $type . ':' . $theme . ':' . $name . ':' . $sub_directory;

  if (isset($files[$key])) {
    return $files[$key];
  }

  if (function_exists('drupal_get_path')) {
    $file = DRUPAL_ROOT . '/' . drupal_get_path('theme', $theme) . "$sub_directory/$name.$type";
    if (is_file($file)) {
      require_once $file;
      $files[$key] = $file;
      return $file;
    }
    else {
      $files[$key] = FALSE;
    }
  }
  return FALSE;
}

/**
 * Load UIkit's include files for theme processing.
 */
uikit_load_include('inc', 'uikit', 'get', 'includes');
uikit_load_include('inc', 'uikit', 'preprocess', 'includes');
uikit_load_include('inc', 'uikit', 'process', 'includes');
uikit_load_include('inc', 'uikit', 'theme', 'includes');
uikit_load_include('inc', 'uikit', 'alter', 'includes');
