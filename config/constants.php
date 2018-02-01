<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 11/4/2016
 * Time: 1:23 PM
 */

return [

    'INPUT_TYPE_FIELD' => [

    '1'         => 'Input Text',
    '2'         => 'Input Radio',
    '3'         => 'Input Checkbox',
    '4'         => 'Input Date',
    '5'         => 'Input Datetime Local',
    '6'         => 'Input email',
    '7'         => 'Input Number',
    '8'         => 'Input Time',
    '9'         => 'Input Url',
    '10'        => 'Input Password',
    '11'        => 'Select Dropdown',
    '12'        => 'Input File',
    '13'        => 'Text Area',

    ],
    'INPUT_TYPE_FIELD_IDENTIFIER' => [

        '1'         => 'basic_name',
        '2'         => 'basic_location',
        '3'         => 'basic_feature_image',
        '4'         => 'basic_price',
        '5'         => 'basic_description'
    ],


    'IMAGE_FOLDER_NAME' => 'images',
    'IMAGE_ASSET_FOLDER_NAME' => 'img',
    'TIMEZONE_API_KEY' => 'AIzaSyAMOy9duCuoptDDXbCIlR5SJ_2AfukPMNM',
    /*when admin add new property default feild type ids*/

    'ADMIN_DEFAULT_PROPERTY_FEILDS_TYPE_ID' =>[

        '1'     => '1',
        '2'     => '1',
        '3'     => '12',
        '4'     => '7',
        '5'     => '13',
    ],
    'MAX_DAYS_NOTIES' => [

        '90' => '3 months',
        '180' => '6 months',
        '270' => '9 months',
        '365' => '1 year',
        '0' => 'Dates unavailable by default',
    ],

    'PROPERTY_REVIEW_REASON' => [
        '1'         => 'Very Bad',
        '2'         => 'Bad',
        '3'         => 'Good',
        '4'         => 'Very Good',
        '5'         => 'Excellent',
    ],

    'CANCELLATION_POLICY_DURATION_IN_DAYS' => [

        '1d'         => '1',
        '5d'         => '5',
        '2w'         => '14',
        '1m'         => '30',
        'owner'      => '1'        
    ],


     'CANCELLATION_POLICY_DURATION_IN_HOURS' => [

        '1d'         => '24',
        '5d'         => '120',
        '2w'         => '336',
        '1m'         => '720',
        'owner'      => '24'        
    ],

    'CANCELLATION_POLICY_DURATION_IN_MINUTES' => [

        '1d'         => '1440',
        '5d'         => '7200',
        '2w'         => '20160',
        '1m'         => '43800',
        'owner'      => '1440'        
    ],

    'START_TIME' => '12:00:00',
    'OFFSET_LIMIT_PROPERTY_SEARCH'   => '4',
    'SEARCH_DISTANCE'   => '50',
    'ASIA_TIMEZONE' => 'Asia/Calcutta',
];
