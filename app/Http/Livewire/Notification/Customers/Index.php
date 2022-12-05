<?php

namespace App\Http\Livewire\Notification\Customers;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public ?string $search = null;
   public $perPage = 10;
   public $sortField = 'id';
   public $sortAsc = true;
   public bool $bulkDisabled = true;
   public $selectedData = [];
   public $title;
   public $body;
   public function render()
   {

      $this->bulkDisabled = count($this->selectedData) < 1;

      $searchTerm = '%' . $this->search . '%';
      $customers = User::where('account_type', "Customer")->whereLike(
         [
            'name',
            'phone_number',
         ],
         $searchTerm
      )
         ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
         ->paginate($this->perPage);
      return view('livewire.notification.customers.index', [
         'users' => $customers,
      ]);
   }
   public function SelectedNotify()
   {
      foreach ($this->selectedData as $value) {

         Notification::create([
            "user_code" => $value,
            "name" => User::where('user_code', $value)->pluck("name")->implode(''),
            "title" => $this->title,
            "body" => $this->body,
            "image" => "null",
            "date" => now(),
            "status" => 1
         ]);
         $fcm = User::where('user_code', $value)->pluck("fcm_token")->implode('');
         $this->sendFirebaseNotification($fcm);
      }
      Session()->flash("message", "Notification Sent");
      return redirect()->to('/notification/customer');
   }
   public function MassiveNotify()
   {
      return redirect()->to('/notification/customer');
   }
   public function sendFirebaseNotification($fcm_token)
   {
      $token_default = [
         "dNCXRn5ISZCH3LxStsbv6N:APA91bF9PQYSUYcBxFl3MhYRieB-8XnnojhU0t3QL89rLFydStIQPeMlNorWoGulScjpmZuhzes7ovE5w0pL7jhVq4MF5Km0rVIQGDi6eLtrk_gCFhxe2j_5MibRXER-eN7HkVMDSz03",
      ];
      $tokenzined = [
       $fcm_token
      ];
      info($tokenzined);
      $token = $fcm_token == null ? $token_default : $tokenzined;
      $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

      $fcmNotification = [
         'registration_ids'  => $token, //device token (smartphones unique identifier)
         'notification' => [
            'title' => $this->title, //notification title
            'body' => $this->body, //notification body
         ],
         'data' => [
            "route" => '/notification'
         ]
      ];

      $headers = [
         'Authorization: key=AAAAF82SEcA:APA91bG8wzqRzTiPtl-IAVH6BvjFpAIjR23PWks_BAcclupXSZXE-f_YFISD-nfKCWpwym7G60EmH1oa1hScvreTtVAHrkH_BFiCpP66zvzTslZyXSCDgpiXaJVtv4gc2zKm-YC3wXvx', //firebase server key
         'Content-Type: application/json'
      ];

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $fcmUrl);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
      $result = curl_exec($ch);
      curl_close($ch);
      return response()->json([
         $result
      ]);
   }
}
