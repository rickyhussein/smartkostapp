<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:notifications_admin', ['only' => ['index']]);
        $this->middleware('permission:notifications_owner', ['only' => ['ownerNotifications']]);
        $this->middleware('permission:notifications_user', ['only' => ['userNotifications']]);
    }

    public function index()
    {
        $status = request()->input('status');
        $title = 'Notifications';

        $inboxs = auth()->user()->notifications()
        ->when($status == 'read', fn($query)=>$query->whereNotNull('read_at'))
        ->when($status == 'unread', fn($query)=>$query->whereNull('read_at'))
        ->paginate(10)
        ->withQueryString();

        return view('notifications.index', compact(
            'inboxs',
            'title'
        ));
    }

    public function ownerNotifications()
    {
        $filter = request()->input('filter','');
        $title = 'Notifications';

        $inboxs = auth()->user()->notifications()
                        ->when($filter == 'read', fn($query)=>$query->whereNotNull('read_at'))
                        ->when($filter == 'unread', fn($query)=>$query->whereNull('read_at'))
                        ->paginate(10)
                        ->withQueryString();

        return view('notifications.ownerNotifications', compact(
            'inboxs',
            'title'
        ));
    }

    public function userNotifications()
    {
        $filter = request()->input('filter','');
        $title = 'Notifications';

        $inboxs = auth()->user()->notifications()
                        ->when($filter == 'read', fn($query)=>$query->whereNotNull('read_at'))
                        ->when($filter == 'unread', fn($query)=>$query->whereNull('read_at'))
                        ->paginate(10)
                        ->withQueryString();

        return view('notifications.userNotifications', compact(
            'inboxs',
            'title'
        ));
    }

    public function readMessage($id)
    {
        $notifikasi = auth()->user()->notifications()->where('id', $id)->whereNull('read_at')->first();
        $notifikasi->markAsRead();
        return redirect($notifikasi->data["action"]);
    }
}
