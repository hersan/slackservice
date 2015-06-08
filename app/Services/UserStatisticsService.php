<?php
/**
 * Statistics Service
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


class UserStatisticsService {

    /**
     * @var array
     */
    private $count = [
        'total' => 0,
        'actives' => 0
    ];

    /**
     * @var \Frlnc\Slack\Core\Commander
     */
    private $slack;

    /**
     * @param SlackApi $commander
     */
    public function __construct(SlackApi $commander){

        $this->slack = $commander;

    }

    /**
     * Get quantity of users in the channel
     *
     * @return array
     */
    public function usersStats()
    {
        return $this->totalUsers();
    }

    /**
     * Count total and active users
     *
     * @return array
     */
    private function totalUsers()
    {
        /**
         * @var
         */
        $response = $this->slack->execute('rtm.start');

        $rtm = $response->getBody();

        foreach($rtm['users'] as $user)
        {
            if($this->isReal($user))
            {
                $this->count['total']++;
            }

            if($this->isActive($user) && $this->isReal($user))
            {
                $this->count['actives']++;
            }
        }

        return $this->count;
    }

    /**
     * Determine if a user is real and not a bot
     *
     * @param array $user
     *
     * @return bool
     */
    private function isReal($user)
    {
        return (isset($user['is_bot']) and !$user['is_bot']) and $user['id'] != 'USLACKBOT';
    }

    /**
     * Determine if a user is not away
     *
     * @param  array $user
     *
     * @return bool
     */
    private function isActive($user)
    {
        return $user['presence'] == 'active';
    }

}