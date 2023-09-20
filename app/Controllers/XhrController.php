<?php

namespace App;

use App\Controllers\BaseController;
use App\Libraries\XhrResponse;

abstract class XhrController extends BaseController {

    /**
     * @param XhrResponse $xhrResponse
     * @return string
     */
    protected function response(XhrResponse $xhrResponse): string
    {
        return $xhrResponse->toJson();
    }
}