<ul class="nav nav-pills nav-fill">
   <li class="nav-item">
     <a class="nav-link @if(Route::currentRouteName() === 'survey.show') active @endif" href="{!! route('survey.show',$survey->code) !!}" aria-current="page" href="#"> Details</a>
   </li>
   <li class="nav-item">
      <a class="nav-link @if(Route::currentRouteName() === 'survey.questions.index') active @endif" href="{!! route('survey.questions.index',$survey->code) !!}"> Questions</a>
    </li>
   {{-- <li class="nav-item">
     <a class="nav-link" href="#"><i class="fal fa-users"></i> Players</a>
   </li> --}}
   {{-- <li class="nav-item">
     <a class="nav-link" href="#"><i class="fal fa-trophy-alt"></i> Lead Board</a>
   </li> --}}
   {{-- <li class="nav-item">
     <a class="nav-link " href="#" ><i class="fal fa-analytics"></i> Reports</a>
   </li> --}}
</ul>
