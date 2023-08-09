<?php

namespace App\Http\Livewire\Activity;

use App\Exports\ActivityExport;
use App\Models\activity_log;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
   use WithPagination;

   protected $paginationTheme = 'bootstrap';
   public $perPage = 25;
   public $sortField = 'created_at';
   public $sortAsc = true;
   public $search = null;
   public $startDate = null;
   public $endDate = null;
   public $userCode = null;
   public $users;

   public function whereBetweenDate(Builder $query, string $column = null, string $start = null, string $end = null): Builder
   {
      if (is_null($start) && is_null($end)) {
         return $query;
      }

      if (!is_null($start) && Carbon::parse($start)->isSameDay(Carbon::parse($end))) {
         return $query->where($column, '=', $start);
      }
      $end = $end == null ? Carbon::now()->endOfMonth()->format('Y-m-d') : $end;
      return $query->whereBetween($column, [$start, $end]);
   }
   public function render()
   {


      return view('livewire.activity.dashboard', [
         'activities' => $this->data()
      ]);
   }
   public function updatedStartDate()
   {
      $this->render();
      $this->mount();
   }
   public function updatedEndDate()
   {
      $this->render();
      $this->mount();
   }
   public function updatedUserCode()
   {
      $this->render();
      $this->mount();
   }
   public function mount()
   {
      $this->users = User::all();
   }
   public function export()
   {
      return Excel::download(new ActivityExport($this->data()), 'activities.xlsx');
   }
   public function data()
   {
      $searchTerm = '%' . $this->search . '%';
      $userCode = '%' . $this->userCode . '%';
      $query = activity_log::with('user')
         ->search($searchTerm)
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->startDate, $this->endDate);
         })
         ->where('user_code', 'LIKE', $userCode)
         ->orderBy($this->sortField, $this->sortAsc ? 'desc' : 'asc');

      return $query->paginate($this->perPage);
   }
}