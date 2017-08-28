<?php

// Copy this file to /craft/config/imgixurl.php

return array(
    '*' => array(
        'defaultSettings' => array(
            "auto" => "compress,format"
        ),
        'sources' => array(
            array(
                'original' => 'sampledomain.s3.amazonaws.com',
                'imgix' => 'https://sampledomain.imgix.net',
                'token' => 'abcde12345', // optional
                // see https://docs.imgix.com/setup/securing-images for more on secure token.
            )
        )
    )
    // '.dev' => array(
    //     'sources' => null
    // )
    // this would allow you to turn off imgix routing on .dev domains, saving you some bandwidth.
    // the full image url would be returned.
);
