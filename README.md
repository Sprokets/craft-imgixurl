# Imgix Url plugin for Craft CMS

Build imgix urls, including secure images.

```twig
<img src="{{ craft.imgixUrl.getUrl(imageAsset, {w: 75}) }}" alt="75px Image from imgix!">
```

## Installation

To install Imgix Url, follow these steps:

1. Download & unzip the file and place the `imgixurl` directory into your `craft/plugins` directory
2. Install plugin in the Craft Control Panel under Settings > Plugins
3. The plugin folder should be named `imgixurl` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.
4. Copy the `config-sample.php` file to `craft/config/imgixurl.php` and make the needed changes

Imgix Url works on Craft 2.4.x and Craft 2.5.x.

## Imgix Url Overview

This is a fairly basic plugin to build imgix urls from craft image assets. In the config file, you provide a list of sources, and optionally some default settings.

Then in your templates, you can simply output imgix urls using [any settings you'd like](https://docs.imgix.com/apis/url).

The sources can optionally support [secure image tokens](https://docs.imgix.com/setup/securing-images) as well.

## Configuring Imgix Url

#### Config file:
```php
// Copy this file to /craft/config/imgixurl.php

return array(
    '*' => array(
        'defaultSettings' => array(
            "auto" => "compress,format"
        ),
        'sources' => array(
            array(
                's3' => 'sampledomain.s3.amazonaws.com',
                'imgix' => 'https://sampledomain.imgix.net',
                'token' => 'abcde12345', // optional
                // see https://docs.imgix.com/setup/securing-images for more on secure token.
            )
        )
    )
    // '.dev' => array()
    // this would allow you to turn off imgix routing on .dev domains, saving you some bandwidth.
    // the full image url would be returned.
);
```

## Using Imgix Url

```twig
<img src="{{ craft.imgixUrl.getUrl(imageAsset, {w: 75}) }}" alt="75px Image from imgix!">
```

The plugin simply outputs a url, so it's up to you to create any markup, including responsive images. Imgix makes a lot of this very simple though, especially for [simple pixel-density cases](https://docs.imgix.com/apis/url/dpr):

```twig
<img
  src="{{ craft.imgixUrl.getUrl(imageAsset, {w: 75}) }}"
  srcset="{{ craft.imgixUrl.getUrl(imageAsset, {w: 75, dpr: 2}) }} 2x"
  alt="75px Image and 2x image from imgix!"
>
```