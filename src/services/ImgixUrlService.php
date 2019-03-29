<?php
/**
 * Imgix Url plugin for Craft CMS 3.x
 *
 * Imgix Url
 *
 * @link      https://www.sprokets.com
 * @copyright Copyright (c) 2019 sprokets
 */

namespace sprokets\imgixurl\services;

use sprokets\imgixurl\ImgixUrl;

use Craft;
use craft\base\Component;

/**
 * ImgixUrlService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    sprokets
 * @package   ImgixUrl
 * @since     3.0.0
 */
class ImgixUrlService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     ImgixUrl::$plugin->imgixUrlService->getUrl()
     *
     * @param object $imgInput Craft asset
     * @param object $settings settings overrides
     * @return string
     */
    public function getUrl($imgInput, $settings=array()) {
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
