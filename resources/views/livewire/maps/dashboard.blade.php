<div>
   <div class="card">
       <h5 class="card-header">Search Filter</h5>
       <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50">
           <div class="col-md-4 user_role">
               <div class="form-group">

               </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">

               </div>
           </div>
           <div class="col-md-2">
           </div>
           <div class="col-md-3">
           </div>
       </div>
   </div>
   <div id="map" style="width:100%; height:800px"></div>
</div>

<script defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>
<script>
   let map, activeInfoWindow, markers = [];

   /* ----------------------------- Initialize Map ----------------------------- */
   function initMap() {
       map = new google.maps.Map(document.getElementById("map"), {
           center: {
               lat: -1.292066,
               lng: 36.821945,
           },
           zoom: 12,
           mapTypeId: '{{ $typeMap }}'
       });
       map.addListener("click", function(event) {
           mapClicked(event);
       });

       initMarkers();
   }

   /* --------------------------- Initialize Markers --------------------------- */
   function initMarkers() {
       const initialMarkers = <?php echo json_encode($initialMarkers); ?>;
       for (let index = 0; index < initialMarkers.length; index++) {
           var image = new google.maps.MarkerImage("{{ asset('app-assets/images/pin.png')}}", null, null, null, new google.maps.Size(40,52));

           const markerData = initialMarkers[index];
           const marker = new google.maps.Marker({
               position: markerData.position,
               icon: image,
               map: map,
               label: markerData.PlotNumber,
           });
           markers.push(marker);

           const infowindow = new google.maps.InfoWindow({

               // content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
               content: `
               <div id="content">
                   <div id="siteNotice"> </div>

             <img
               src="{{asset('app-assets/images/logo2.jpeg')}}"
               alt="avatar"
               height="50"
             />
               <h1 id="firstHeading" class="firstHeading">${markerData.customer_name}</h1>
                   <div id="bodyContent">
                       <p><b>Location: </b>${markerData.position.lat}, ${markerData.position.lng}
                       <p><b>Customer Name: </b>${markerData.customer_name}
                        <p><b>Approval: </b>${markerData.approval}
                       <p><b>Status: </b>${markerData.status}
                     <p><b>More info: </b><a href="{{ URL('/customer/${markerData.id}/edit') }}">${markerData.customer_name}</a>


                   </div>
               </div>
               `,
           });
           marker.addListener("click", (event) => {
               if (activeInfoWindow) {
                   activeInfoWindow.close();
               }
               infowindow.open({
                   anchor: marker,
                   shouldFocus: false,
                   map
               });
               activeInfoWindow = infowindow;
               markerClicked(marker, index);
           });

           marker.addListener("dragend", (event) => {
               markerDragEnd(event, index);
           });
       }
   }

   /* ------------------------- Handle Map Click Event ------------------------- */
   function mapClicked(event) {
       console.log(map);
       console.log(event.latLng.lat(), event.latLng.lng());
   }

   /* ------------------------ Handle Marker Click Event ----------------------- */
   function markerClicked(marker, index) {
       console.log(map);
       console.log(marker.position.lat());
       console.log(marker.position.lng());
   }

   /* ----------------------- Handle Marker DragEnd Event ---------------------- */
   function markerDragEnd(event, index) {
       console.log(map);
       console.log(event.latLng.lat());
       console.log(event.latLng.lng());
   }
</script>
