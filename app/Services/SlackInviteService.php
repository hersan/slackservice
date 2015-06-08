<?php
/**
 * Invitation Service
 *
 * @author      Herminio Heredia <herminio.heredia@hotmail.com>
 * @link        http://thinkingoo.wordpress.com/
 * @version     1.0.0
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace App\Services;

use Frlnc\Slack\Core\Commander as SlackApi;


class SlackInviteService {

    /**
     * @var SlackApi
     */
    private $slack;

    /**
     * @param SlackApi $commander
     */
    public function __construct(SlackApi $commander)
    {
        $this->slack = $commander;
    }

    /**
     * Sent a invitation
     *
     * @param array $fields
     *
     * @return array
     */
    public function sendInvitation(Array $fields)
    {
        $request = $this->slack->execute('users.admin.invite', $fields);

        return $request->getBody();
    }

}