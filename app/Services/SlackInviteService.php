<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 06/06/2015
 * Time: 04:40 PM
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