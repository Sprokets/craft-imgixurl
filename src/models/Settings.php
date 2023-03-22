<?php

/**
 * imgixurl plugin for Craft CMS 3.x
 *
 * Build imgix urls from assets, including secure images.
 *
 * @link      https://sprokets.net
 * @copyright Copyright (c) 2018 sprokets
 */

namespace sprokets\imgixurl\models;

use sprokets\imgixurl\ImgixUrl;

use Craft;
use craft\base\Model;

/**
 * Imgixurl Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    sprokets
 * @package   Imgixurl
 * @since     2.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var mixed array The default settings configuration.
     */
    public $defaultSettings = [];

    /**
     * @var mixed array The sources list.
     */
    public $sources = [];
}
