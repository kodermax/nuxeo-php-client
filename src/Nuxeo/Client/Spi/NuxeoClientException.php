<?php
/**
 * (C) Copyright 2016 Nuxeo SA (http://nuxeo.com/) and contributors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Contributors:
 *     Pierre-Gildas MILLON <pgmillon@nuxeo.com>
 */

namespace Nuxeo\Client\Spi;

use Exception;
use JMS\Serializer\Annotation as Serializer;

class NuxeoClientException extends \RuntimeException {

  const INTERNAL_ERROR_STATUS = 666;

  const className = __CLASS__;

  public function __construct($message = '', $code = self::INTERNAL_ERROR_STATUS, Exception $previous = null) {
    if(null !== $previous && '' === $message) {
      $message = $previous->getMessage();
    }

    parent::__construct($message, $code, $previous);
  }

  /**
   * @param \Exception $previous
   * @param string $message
   * @param int $code
   * @return NuxeoClientException
   */
  public static function fromPrevious($previous, $message='', $code=self::INTERNAL_ERROR_STATUS) {
    return new static($message, $code, $previous);
  }

}
