<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;
use Exception;
use App\Http\Traits\JsonResponse;

class NotificationController extends Controller
{

    use JsonResponse;
    public function sendNotification(Request $request)
{
    $request->validate([
        'title' => 'required',
        'body' => 'required'
    ]);

    try {
        $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        // Send the push notification
        Larafirebase::withTitle($request->title)
            ->withBody($request->body)
            ->sendMessage($fcmTokens);

        // Save the title and message to the database
        Notification::create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return $this->successResponse('Notification Sent Successfully!');
    } catch (\Exception $e) {
        report($e);
        return $this->errorResponse('Error, Something went wrong while sending the notification.');
    }
}

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return $this->successResponse('Token updated successfully');
        }catch(\Exception $e){
            return $this->errorResponse('An error occured'. $e->getMessage());
        }
    }
}
