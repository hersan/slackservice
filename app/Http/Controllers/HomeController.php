<?php
/**
 * Home Controller
 *
 * @author      Herminio Heredia <herminio.heredia@hotmail.com>
 * @link        http://thinkingoo.wordpress.com/
 * @version     1.0.0
 */
namespace App\Http\Controllers;

use App\Services\SlackInviteService;
use App\Services\UserStatisticsService;
use Illuminate\Http\Request;

class HomeController extends Controller{

    /**
     * @var UserStatisticsService
     */
    private $slackStatistics;

    /**
     * @var SlackInviteService
     */
    private $inviteService;

    /**
     * @param UserStatisticsService $slackStatistics
     * @internal param UserStatisticsService $slackStatics
     */
    public function __construct(UserStatisticsService $slackStatistics, SlackInviteService $inviteService)
    {
        $this->$slackStatistics = $slackStatistics;
        $this->inviteService = $inviteService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        $stats = $this->slackStatistics->usersStats();

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