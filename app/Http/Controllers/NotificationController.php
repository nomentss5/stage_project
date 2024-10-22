<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Notification_recruteur;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class NotificationController extends Controller
{
    // public function getNotification(){
    //     $notification = Notification::join('users', 'notification.id_user', '=', 'users.id')
    //     ->select('users.name', 'users.id', 'notification.type', 'notification.created_at', 'notification.id')
    //     ->orderBy('notification.id', 'DESC')
    //     ->get();

    //     return response()->json($notification);
    // }

    public function getNotificationRecruteur($id_recruteur){
        $notification = DB::table('v_notification')
        ->where('id_recruteur', $id_recruteur)
        ->where('is_delete', false)
        ->orderBy('created_at', 'DESC')
        ->get();

        $alert=  DB::table('v_notification')
        ->where('id_recruteur', $id_recruteur)
        ->where('is_read', false)
        ->count();

        // return response()->json($notification);

        return response()->json([
            'notification' => $notification,
            'alert' => $alert,
        ]);
    }

    public function update_notification($id_recruteur){
        $notification_recruteur = Notification_recruteur::where('id_recruteur', $id_recruteur)
        ->where('is_read', false)
        ->update(['is_read' => true]);

        // return response()->json($notification_recruteur);
    }

    public function delete_notification_recruteur($id_recruteur, $id_notification){
        $notification_recruteur = Notification_recruteur::where('id_recruteur', $id_recruteur)
        ->where('id_notification', $id_notification)
        ->update(['is_delete' => true]);
    }


    // inserer notification dans la table notification et notification_recruteur
    // avoir deux parametre l'id du candidat $id_user et le type de notification $type 0 pour notif nouveau candidat et 1 pour notif completion d'entretient
    public function notification_create($id_user, $type){
        $notification = Notification::create([
            'id_user' => $id_user,
            'type' => $type,
        ]);


        $users = User::where('level', 0)
        ->get();

        foreach ($users as $user) {

            $notification_recruteur = Notification_recruteur::create([
                'id_recruteur' => $user->id,
                'id_notification' => $notification->id,
                // 'is_read' => false,
                // 'is_deleted' => false,
            ]);
        }
    }

}