<?php

namespace Aacp\OnlineConvertApiBundle\Helper;

class Constants
{
    /**
     * Statutes for Jobs from online-convert.com
     */
    const STATUS_COMPLETED = 'completed';
    const STATUS_QUEUED = 'queued';
    const STATUS_DOWNLOADING = 'downloading';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_FAILED = 'failed';
    const STATUS_INVALID = 'invalid';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_READY = 'ready';

    /**
     * @const string INPUT_REMOTE Used for url
     */
    const INPUT_REMOTE = 'remote';

    /**
     * @const string INPUT_UPLOAD Used for local files
     */
    const INPUT_UPLOAD = 'upload';
}
