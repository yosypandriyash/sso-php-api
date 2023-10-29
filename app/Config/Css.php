<?php namespace Config;

class Css
{
    //Set the input scss files and output css after less compilation

    public $filesConfig = [
        [
            'input' => '/index.scss',
            'output' => 'assets/css/main.css'
        ],
        /* [
            'input' => '/assets/less/admin.less',
            'output' => 'css/admin.css'
        ], */
    ];
}
