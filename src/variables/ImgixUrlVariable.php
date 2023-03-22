<?php

/**
 * Imgix Url plugin for Craft CMS 3.x
 *
 * Imgix Url
 *
 * @link      https://www.sprokets.com
 * @copyright Copyright (c) 2019 sprokets
 */

namespace sprokets\imgixurl\variables;

use Craft;

use craft\elements\Asset;
use Exception;
use sprokets\imgixurl\ImgixUrl;
use yii\web\HttpException;
use yii\db\Exception as DbException;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

/**
 * Imgix Url Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.imgixUrl }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    sprokets
 * @package   ImgixUrl
 * @since     3.0.0
 */
class ImgixUrlVariable
{
    // Public Methods
    // =========================================================================

    /**
     * 
     * @param Asset|string $imgInput 
     * @param array<mixed> $settings 
     * @return string|null 
     * @throws Exception 
     * @throws HttpException 
     * @throws DbException 
     * @throws InvalidArgumentException 
     * @throws InvalidConfigException 
     */
    public function getUrl(Asset|string $imgInput, array $settings = []): ?string
    {
        return ImgixUrl::$plugin->imgixUrlService->getUrl($imgInput, $settings);
    }

    /**
     * 
     * @param Asset $asset 
     * @return string|null
     * @throws InvalidConfigException 
     */
    public function getRawAssetUrl(Asset $asset): ?string
    {
        return ImgixUrl::$plugin->imgixUrlService->getRawAssetUrl($asset);
    }
}
