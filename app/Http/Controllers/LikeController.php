<?php

namespace App\Http\Controllers;

use App\Model\Like;
use Illuminate\Http\Request;
use App\Model\Reply;
use App\Events\LikeEvent;

class LikeController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function Likeit(Reply $reply)
    {
        $reply->Like()->create([
            'user_id' => auth()->id()
        ]);
        broadcast(new LikeEvent($reply->id,1))->toOthers();
    }

    public function unLikeit(Reply $reply)
    {
        $reply->Like()->where('user_id',auth()->id())->first()->delete();
        broadcast(new LikeEvent($reply->id,0))->toOthers();
    }
}
