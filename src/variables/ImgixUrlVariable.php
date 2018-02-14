<?php
/**
 * Imgix Url plugin for Craft CMS 3.x
 *
 * Build imgix urls, including secure images.
 *
 * @link      https://sprokets.net
 * @copyright Copyright (c) 2018 sprokets
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
 * @since     1.0.0
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
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
