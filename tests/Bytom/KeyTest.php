<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Bytom\Tests;

use Bytom\BytomClient;

class KeyTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateKey()
    {
        $alias = 'test_alias';
        $pwd = '123456';
        $bytom = new BytomClient();
        $res = $bytom->createKey($alias, $pwd);

        $this->assertEquals(200, $res->getHTTPStatus());
        $this->assertTrue($res->isSucceeded());

        $data = $res->getJSONDecodedBody();
        $this->assertEquals('alias', $data['alias']);
        $this->assertEquals('xpub', $data['xpub']);
        $this->assertEquals('file', $data['file']);
    }
}
