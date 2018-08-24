<?php
/**
 * imgixurl plugin for Craft CMS 3.x
 *
 * Build imgix urls from assets, including secure images.
 *
 * @link      https://sprokets.net
 * @copyright Copyright (c) 2018 sprokets
 */

namespace sprokets\imgixurl\variables;

use sprokets\imgixurl\Imgixurl;

use Craft;

/**
 * imgixurl Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.imgixurl }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    sprokets
 * @package   Imgixurl
 * @since     2.0.0
 */
class ImgixurlVariable
{
    // Public Methods
    // =========================================================================

    /**
     *
     * @param object $imgInput Craft asset
     * @param object $settings settings overrides
     * @return string
     */
    function getUrl($imgInput, $settings=array()) {
      // print_r(\sprokets\imgixurl\Imgixurl::getInstance()->getSettings()->sources);
      // die();
      $img = $imgInput;
      if(!is_string($imgInput)) {
        $img = $imgInput->getUrl();
      }

      $sources = ImgixUrl::getInstance()->getSettings()->sources; //craft()->config->get('sources', 'imgixurl');


      if(!is_array($sources)) {

        $transSettings = array();
        if(isset($settings['w'])) {
          $transSettings['width'] = $settings['w'];
        }

        if(isset($settings['h'])) {
          $transSettings['height'] = $settings['h'];
        }

        return $imgInput->getUrl($transSettings);

      }

      $defaultSettings = ImgixUrl::getInstance()->getSettings()->defaultSettings;

      if(!is_array($defaultSettings)) {
        $defaultSettings = array();
      }

      $settingsString = http_build_query(array_merge($defaultSettings, $settings));

      $filteredImg = explode('?', $img)[0];

      $imgPath = '';
      $i = 0;

      while ($i < sizeof($sources) && $imgPath == '') {
        $source = $sources[$i];

        $pos = strpos($filteredImg, $source['original']);

        if($pos !== false) {
          $part = substr($filteredImg, $pos + strlen($source['original'])) . '?' . $settingsString;
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
