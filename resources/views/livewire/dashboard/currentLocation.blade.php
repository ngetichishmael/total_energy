 <div class="col-lg-4 col-md-6 col-12">
     <div class="card card-developer-meetup">
         <div class="text-center meetup-img-wrapper rounded-top">
             <img src="{{ asset('app-assets/images/illustration/marketing.svg') }}" alt="Meeting Pic" height="170" />
         </div>
         <div class="card-body">
             <div class="meetup-header d-flex align-items-center">
                 <div class="meetup-day">
                     <h6 class="mb-0">{{ date_format(now(), 'M') }}</h6>
                     <h3 class="mb-0">{{ date_format(now(), 'd') }}</h3>
                 </div>
                 <div class="my-auto">
                     <h4 class="card-title mb-25">Total Energies</h4>
                     <p class="mb-0 card-text">Transforming Ourselves to Reinvent Energy</p>
                 </div>
             </div>
             <div class="media" style="background: white">
                 <div class="mr-1 rounded avatar d-flex align-items-center" style="background: white">
                     <div class="avatar-content" style="background: white">
                         <i data-feather="calendar" class="avatar-icon font-medium-3" style="color: #4883ee;"></i>
                     </div>
                     &nbsp;&nbsp;&nbsp;
                     <div class="pl-3" style="background: white">
                         <h6 class="mb-0" style="color: gray;">{{ date_format(now(), 'D, F, Y') }}
                         </h6>
                         <small style="color: darkgray;">8:AM to 5:PM</small>
                     </div>
                 </div>
             </div>
             <div class="media mt-2" style="background: white">
                 <div class="mr-1 rounded avatar align-items-center" style="background: white">
                     <div class="avatar-content">
                         <i data-feather="map-pin" class="avatar-icon font-medium-3" style="color: #4883ee;"></i>
                     </div>
                     &nbsp;&nbsp;&nbsp;
                     <div class="media-body pl-3" style="background: white;">
                         <h6 class="mb-0" style="background: white;"> </h6>
                         <small style="background: white; color: darkgrey">Nairobi, Kenya</small>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
