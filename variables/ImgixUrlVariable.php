<?php
/**
 * Imgix Url plugin for Craft CMS
 *
 * Imgix Url Variable
 *
 * --snip--
 * Craft allows plugins to provide their own template variables, accessible from the {{ craft }} global variable
 * (e.g. {{ craft.pluginName }}).
 *
 * https://craftcms.com/docs/plugins/variables
 * --snip--
 *
 * @author    Sprokets
 * @copyright Copyright (c) 2017 Sprokets
 * @link      http://sprokets.net
 * @package   ImgixUrl
 * @since     0.0.0
 */

namespace Craft;

class ImgixUrlVariable
{
  /**
   * Whatever you want to output to a Twig template can go into a Variable method. You can have as many variable
   * functions as you want.  From any Twig template, call it like this:
   *
   *     {{ craft.imgixUrl.exampleVariable }}
   *
   * Or, if your variable requires input from Twig:
   *
   *     {{ craft.imgixUrl.exampleVariable(twigValue) }}
   */
  function getUrl($img, $settings=array()) {
    if(!is_string($img)) {
      $img = $img->getUrl();
    }

    $sources = craft()->config->get('sources', 'imgixurl');

    $defaultSettings = craft()->config->get('defaultSettings', 'imgixurl');

    if(!is_array($defaultSettings)) {
      $defaultSettings = array();
    }

    $settingsString = http_build_query(array_merge($defaultSettings, $settings));

    $filteredImg = explode('?', $img)[0];

    $imgPath = '';
    $i = 0;

    while ($i < sizeof($sources) && $imgPath == '') {
      $source = $sources[$i];

      $pos = strpos($filteredImg, $source['s3']);

      if($pos !== false) {
        $part = substr($filteredImg, $pos + strlen($source['s3'])) . '?' . $settingsString;
        $imgPath = $source['imgix'] . $part;

        if(isset($source['token'])) {
          $imgPath .= '&s=' . md5($source['token'] . $part);
        }
      }
      $i++;
    }




    return empty($imgPath) ? $img : $imgPath;

  }
}