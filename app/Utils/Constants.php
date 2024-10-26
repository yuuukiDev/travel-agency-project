<?php

namespace App\Utils;

class Constants
{
    /**
     * class used to make constants of variables that might use in the future
     */

    // API
    public static $API_SUCCESS_STATUS = 'Success';

    public static $API_FAILED_STATUS = 'Failed';

    public static $API_SUCCESS_MESSAGE = 'Request succeded';

    public static $API_FAILED_MESSAGE = 'Request Failed';

    // USER VERIFICATION

    public static $USER_IS_ACTIVE = 1;

    public static $USER_INACTIVE = 0;

    public static $USER_BLOCKED = 2;
}
