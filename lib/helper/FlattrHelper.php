<?php

/**
 * Helpers for sfFlattrPlugin.
 *
 * @package     sfFlattrPlugin
 * @subpackage  helper
 * @author      Tobias Sjösten <tobias.sjosten@gmail.com>
 * @version     SVN: $Id$
 */

/**
 * Build a Flattr button.
 *
 * @param   string $url
 * @param   string $title
 * @param   string $description
 * @param   string $category
 * @param   string $uid
 * @param   bool   $html5
 *
 * @return  string
 */
function flattr_button($url, $title = null, $description = null, $category = null, $uid = null, $html5 = false)
{
  if (!$title)
  {
    $title = sfConfig::get('app_sf_flattr_plugin_title');
  }
  if (!$description)
  {
    $description = sfConfig::get('app_sf_flattr_plugin_description');
  }
  if (!$category)
  {
    $category = sfConfig::get('app_sf_flattr_plugin_category');
  }
  if (!$uid)
  {
    $uid = sfConfig::get('app_sf_flattr_plugin_uid');
  }
  if (null === $html5)
  {
    $html5 = sfConfig::get('app_sf_flattr_plugin_html5', false);
  }

  // These attributes are required by Flattr.
  if (!$url || !$title || !$description || !$category)
  {
    return false;
  }

  // Titles must be between 5 and 100 characters.
  $title_len = strlen($title);
  if ($title_len < 5 || $title_len > 100)
  {
    return false;
  }

  // Descriptions must be between 5 and 1000 characters.
  $description_len = strlen($description);
  if ($description_len < 5 || $description_len > 1000)
  {
    return false;
  }

  if ($html5)
  {
    $button = '<a
      class="FlattrButton"
      style="display:none;"
      title="%s"
      data-flattr-uid="%s"
      data-flattr-category="%s"
      href="%s">
      %s
      </a>';
  }
  else
  {
    $button = '<a
      class="FlattrButton"
      style="display:none;"
      title="%s"
      rev="flattr;uid:%s;category:%s;"
      href="%s">
      %s
      </a>';
  }

  return sprintf($button, $title, $uid, $category, $url, $description);
}
