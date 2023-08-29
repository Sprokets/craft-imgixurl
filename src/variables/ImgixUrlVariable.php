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

use sprokets\imgixurl\ImgixUrl;

use Craft;

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
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.imgixUrl.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.imgixUrl.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function getUrl($imgInput, $settings=[])
    {
        return ImgixUrl::$plugin->imgixUrlService->getUrl($imgInput, $settings);
    }

    public function getRawAssetUrl($asset) {
        return ImgixUrl::$plugin->imgixUrlService->getRawAssetUrl($asset);
    }
}
