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

use Craft;

use Exception;
use craft\base\Component;
use craft\elements\Asset;
use yii\web\HttpException;
use craft\base\FsInterface;
use sprokets\imgixurl\ImgixUrl;
use yii\base\InvalidConfigException;
use yii\db\Exception as DbException;
use yii\base\InvalidArgumentException;

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
   * 
   * @param Asset $asset 
   * @return string|null 
   * @throws InvalidConfigException 
   */
  public function getRawAssetUrl(Asset $asset): ?string
  {
    if (!ImgixUrl::$plugin->isImageOptimizedInstalled) {
      return $asset->getUrl();
    } else {
      $baseUrl = "";
      $fs = $asset->getVolume()->getFs();
      if ($fs->hasUrls) {
        $baseUrl = $fs->getRootUrl();
      }
      return $baseUrl . (substr($baseUrl, -1) == '/' ? '' : '/') . $asset->getPath();
    }
  }

  /**
   * 
   * @param Asset|string $imgInput 
   * @param array<mixed> $settings 
   * @return string|null 
   * @throws Exception 
   * @throws InvalidConfigException 
   * @throws HttpException 
   * @throws DbException 
   * @throws InvalidArgumentException 
   */
  public function getUrl(Asset|string $imgInput, array $settings = []): ?string
  {

    $img = $imgInput;
    if (!is_string($imgInput)) {
      /**
       * @var \craft\services\Plugins $pluginsService
       */
      $pluginsService = Craft::$app->getPlugins();
      $isImageOptimizedInstalled = $pluginsService->getPlugin('image-optimize');

      if (!$isImageOptimizedInstalled) {
        $img = $imgInput->getUrl();
        if ($img === null) {
          return null;
        }
      } else {
        $baseUrl = "";
        $fs = $imgInput->getVolume()->getFs();
        if ($fs->hasUrls) {
          $baseUrl = $fs->getRootUrl();
        }
        $img = $baseUrl . (substr($baseUrl, -1) == '/' ? '' : '/') . $imgInput->getPath();
      }
    }

    $config = Craft::$app->config->getConfigFromFile('imgixurl');
    $sources = $config['sources'];

    if (!is_array($sources)) {

      $transSettings = array();
      if (isset($settings['w'])) {
        $transSettings['width'] = $settings['w'];
      }

      if (isset($settings['h'])) {
        $transSettings['height'] = $settings['h'];
      }

      return $imgInput->getUrl($transSettings);
    }

    $defaultSettings = $config['defaultSettings'];

    if (!is_array($defaultSettings)) {
      $defaultSettings = array();
    }

    $settingsString = http_build_query(array_merge($defaultSettings, $settings));

    $filteredImg = explode('?', $img)[0];

    $imgPath = '';
    $i = 0;

    while ($i < sizeof($sources) && $imgPath == '') {
      $source = $sources[$i];

      $pos = strpos($filteredImg, $source['original']);

      if ($pos !== false) {
        $part = substr($filteredImg, $pos + strlen($source['original'])) . '?' . $settingsString;
        $imgPath = $source['imgix'] . $part;

        if (isset($source['token'])) {
          $imgPath .= '&s=' . md5($source['token'] . $part);
        }
      }
      $i++;
    }
    return empty($imgPath) ? $img : $imgPath;
  }
}
