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
 * @param  array $options  Array with configuration for the button. Required
 * options left out are fetched from the app.yml configuration.
 *
 * @return  string
 */
//function flattr_button($url, $options['title'] = null, $options['description'] = null, $options['category'] = null, $options['uid'] = null, $options['html5'] = false)
function flattr_button($url, $options = array())
{
  if (empty($options['title']))
  {
    $options['title'] = sfConfig::get('app_sf_flattr_plugin_title');
  }
  if (empty($options['description']))
  {
    $options['description'] = sfConfig::get('app_sf_flattr_plugin_description');
  }
  if (empty($options['category']))
  {
    $options['category'] = sfConfig::get('app_sf_flattr_plugin_category');
  }
  if (empty($options['uid']))
  {
    $options['uid'] = sfConfig::get('app_sf_flattr_plugin_uid');
  }
  if (!isset($options['html5']))
  {
    $options['html5'] = sfConfig::get('app_sf_flattr_plugin_html5', false);
  }

  // These attributes are required by Flattr.
  if (!$url || !$options['title'] || !$options['description'] || !$options['category'])
  {
    return false;
  }

  // Titles must be between 5 and 100 characters.
  $title_len = strlen($options['title']);
  if ($title_len < 5 || $title_len > 100)
  {
    return false;
  }

  // Descriptions must be between 5 and 1000 characters.
  $description_len = strlen($options['description']);
  if ($description_len < 5 || $description_len > 1000)
  {
    return false;
  }

  if ($options['html5'])
  {
    $data = '';
    if (!empty($options['data']))
    {
      foreach ($options['data'] as $key => $value)
      {
        $data .= sprintf(' data-flattr-%s="%s"', $key, $value);
      }
    }

    $button = '<a class="FlattrButton"
      style="display:none;"
      title="%s"
      data-flattr-uid="%s"
      data-flattr-category="%s"
      '.$data.'
      href="%s">
      %s
      </a>';
  }
  else
  {
    $data = '';
    if (!empty($options['data']))
    {
      foreach ($options['data'] as $key => $value)
      {
        $data .= sprintf('%s:%s;', $key, $value);
      }
    }

    $button = '<a class="FlattrButton"
      style="display:none;"
      title="%s"
      rev="flattr;uid:%s;category:%s;'.$data.'"
      href="%s">
      %s
      </a>';
  }

  return sprintf($button,
    $options['title'],
    $options['uid'],
    $options['category'],
    $url,
    $options['description']
  );
}
