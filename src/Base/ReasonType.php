<?php

namespace Google\Visualization\DataSource\Base;

class ReasonType
{
    public const ACCESS_DENIED = 'ACCESS_DENIED';
    public const USER_NOT_AUTHENTICATED = 'USER_NOT_AUTHENTICATED';
    public const UNSUPPORTED_QUERY_OPERATION = 'UNSUPPORTED_QUERY_OPERATION';
    public const INVALID_QUERY = 'INVALID_QUERY';
    public const INVALID_REQUEST = 'INVALID_REQUEST';
    public const INTERNAL_ERROR = 'INTERNAL_ERROR';
    public const NOT_SUPPORTED = 'NOT_SUPPORTED';
    public const DATA_TRUNCATED = 'DATA_TRUNCATED';
    public const NOT_MODIFIED = 'NOT_MODIFIED';
    public const TIMEOUT = 'TIMEOUT';
    public const ILLEGAL_FORMATTING_PATTERNS = 'ILLEGAL_FORMATTING_PATTERNS';
    public const OTHER = 'OTHER';

    public static function getMessageForReasonType($type, $locale)
    {
        return LocaleUtil::getLocalizedMessageFromBundle(__NAMESPACE__ . '\ErrorMessages', $type, $locale);
    }
}
