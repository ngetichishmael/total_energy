<div class="col-lg-3 col-md-4 col-sm-12">
   <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
      <!-- pill tabs navigation -->
      <ul class="nav nav-pills nav-left flex-column" role="tablist">
         <!-- account -->
         <li class="nav-item">
            <a class="nav-link {!! Nav::isResource('account') !!}" href="{!! route('settings.account') !!}">
               <i data-feather='briefcase' class="font-medium-3 me-1"></i>
               <span class="fw-bold">Account</span>
            </a>
         </li>
         <!-- activity logs -->
         <li class="nav-item">
            <a class="nav-link {!! Nav::isResource('activity') !!}" href="{!! route('settings.activity.log') !!}">
               <i data-feather='activity' class="font-medium-3 me-1"></i>
               <span class="fw-bold">Activity logs</span>
            </a>
         </li>
         <!-- Roles and Permissions -->
         {{-- <li class="nav-item">
            <a class="nav-link" href="#" aria-expanded="false" role="tab">
               <i data-feather='lock' class="font-medium-3 me-1"></i>
               <span class="fw-bold">Roles and permissions</span>
            </a>
         </li> --}}
      </ul>
   </div>
</div>
