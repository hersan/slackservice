<?php
/**
 * Created by PhpStorm.
 * User: hheredia
 * Date: 3/06/15
 * Time: 03:22 PM
 */

namespace App\Http\Controllers;

use App\Services\SlackInviteService;
use App\Services\UserStatisticsService;
use Illuminate\Http\Request;

class HomeController extends Controller{

    /**
     * @var UserStatisticsService
     */
    private $slackStatics;

    /**
     * @var SlackInviteService
     */
    private $inviteService;

    /**
     * @param UserStatisticsService $slackStatics
     * @param SlackInviteService $inviteService
     */
    public function __construct(UserStatisticsService $slackStatics, SlackInviteService $inviteService)
    {
        $this->slackStatics = $slackStatics;
        $this->inviteService = $inviteService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $stats = $this->slackStatics->usersStats();

        return view('slack.index', ['stats' => $stats]);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function postInvite(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
        ]);

        $response = $this->inviteService->sendInvitation(
            [
                'email' => $request->get('email'),
                'channels' => env('SLACK_CHANNEL_ID'),
                'first_name' => $request->get('nombre'),
                'last_name' =>$request->get('apellido'),
                'set_active' => true,
                '_attempts' => '1'
            ]
        );

        $messages = null;

        if($response['ok'] == false && ($response['error']=='sent_recently' || $response['error']=='already_invited' ))
        {
            $messages = 'Ya fuiste invitado';
        }

        if($response['ok'] == true)
        {
            $messages = "Una envitación a sido enviada a la cuenta {$request->get('email')}";
        }

        return redirect('/')->with('messages',$messages)->withInput($request->all());
    }

}