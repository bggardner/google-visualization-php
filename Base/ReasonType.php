<?php
  namespace Google\Visualization\DataSource\Base;

  class ReasonType
  {
    const ACCESS_DENIED = "Access denied";
    const USER_NOT_AUTHENTICATED = "User not authenticated";
    const UNSUPPORTED_QUERY_OPERATION = "Unsupported query operation";
    const INVALID_QUERY = "Invalid query";
    const INVALID_REQUEST = "Invalid request.";
    const INTERNAL_ERROR = "An internal error has occurred";
    const NOT_SUPPORTED = "This operation is not supported";
    const DATA_TRUNCATED = "Not all data is received";
    const NOT_MODIFIED = "The data hasn't been changed";
    const TIMEOUT = "The request has timed out";
    const ILLEGAL_FORMATTING_PATTERNS = "Illegal formatting patterns";
    const OTHER = "An unknown error as occurred";
  }
?>
