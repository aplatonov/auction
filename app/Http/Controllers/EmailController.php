<?php

namespace App\Http\Controllers;

use App\Order;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{

    /**
     * Returns contacts view
     *
     * @return view
     */
    public function contacts()
    {
        return view('contacts');
    }	


    /**
     * Sends a mail from contacts page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return view
     */	
	public function send(FeedbackRequest $request){
	    
	    $data = $request->only('name', 'email');
	    $data['user_message'] = explode("\n", $request->get('user_message'));

	    Mail::send('layouts.feedback', $data, function ($message) use ($data)
	    	{
				$message->to('admin@auction.ru')
						->subject('Auction feedback from ' . $data['name'])
						->replyTo($data['email']);
			});

	    return back()
	    	->with('success', 'Сообщение успешно отправлено. Спасибо!');
	}    

}
