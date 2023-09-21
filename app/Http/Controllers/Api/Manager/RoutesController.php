<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Routes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function getRoutes()
    {
        // Get the authenticated user's route_code
        $userRouteCode = Auth::user()->route_code;
    
        // Find routes where the associated user has a route_code matching $userRouteCode
        $routes = Routes::with('user')
            ->whereHas('user', function ($query) use ($userRouteCode) {
                $query->where('route_code', $userRouteCode);
            })
            ->whereHas('user', function ($query) use ($userRouteCode) {
                $query->where('id', '!=', Auth::id()); // Exclude the authenticated user's routes
            })
            ->get();
    
        // Check if any routes were found
        if ($routes->isEmpty()) {
            return response()->json(['message' => 'No routes found.'], 404);
        }
    
        // Return the routes as a JSON response
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Routes Data',
            'data' => $routes]);
    }
    
    
    
    
    
//    public function getRoutes(Request $request)
//    {
//       $authenticatedUserRouteCode = Auth::user()->route_code;
      
//       $routes = Routes::whereHas('user', function ($query) use ($authenticatedUserRouteCode) {
//           $query->where('route_code', $authenticatedUserRouteCode);
//       })
//       ->withCount('RouteSales')
//       ->with(['RouteSales.User' => function ($query) {
//           $query->select('id', 'name', 'user_code', 'email', 'location', 'route_code', 'fcm_token');
//       }])
//       ->get();

//       $result = $routes->map(function ($route) {
//           return [
//               'id' => $route->id,
//               'name' => $route->name,
//               'status' => $route->status,
//               'Type' => $route->Type,
//               'start_date' => $route->start_date,
//               'end_date' => $route->end_date,
//               'created_by_route_code' => (int) $route->user->route_code,
//               'users_count' => count($route->RouteSales->flatMap->User),
//               'users' => $this->getUsersData($route->RouteSales->flatMap->User),
//           ];
//       });

//       return response()->json([
//            'status' => 200,
//            'success' => true,
//            'message' => 'Routes data',
//            'data' => $result,
//        ]);
//    }
   
   private function getUsersData($users)
   {
       if ($users->isEmpty()) {
           return $this->emptyFilterUsers();
       }

       return $users->map(function ($user) {
           return [
               'id' => $user->id,
               'name' => $user->name,
               'user_code' => $user->user_code,
               'email' => $user->email,
               'location' => $user->location,
               'route_code' => $user->route_code,
               'fcm_token' => $user->fcm_token,
           ];
       });
   }
   
   private function emptyFilterUsers()
   {
       return [
           [
               'id' => 0,
               'name' => 'No Sales Associate',
               'user_code' => 'No Sales Associate',
               'email' => 'No Sales Associate',
               'location' => 'No Sales Associate',
               'fcm_token' => 'No Sales Associate',
           ],
       ];
   }
}
