<?php
/**
 * Created by PhpStorm.
 * User: hheredia
 * Date: 5/06/15
 * Time: 04:01 PM
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