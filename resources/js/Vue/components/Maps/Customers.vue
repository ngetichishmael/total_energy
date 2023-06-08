<template>
    <div>
        <GMap ref="mapRef" :center="center" :zoom="12" :map-type-id="typeMap" style="width: 100%; height: 400px;"
            @click="mapClicked">
            <GMarker v-for="(markerData, index) in initialMarkers" :key="index" :position="markerData.position"
                :icon="markerIcon" :label="markerData.PlotNumber" @click="markerClicked(markerData, index)"
                @dragend="markerDragEnd($event, index)">
                <GInfoWindow :position="markerData.position">
                    <div id="content">
                        <div id="siteNotice"></div>
                        <img src="{{ asset('app-assets/images/logo2.jpeg') }}" alt="avatar" height="50" />
                        <h1 id="firstHeading" class="firstHeading">{{ markerData.customer_name }}</h1>
                        <div id="bodyContent">
                            <p><b>Location: </b>{{ markerData.position.lat }}, {{ markerData.position.lng }}</p>
                            <p><b>Customer Name: </b>{{ markerData.customer_name }}</p>
                            <p><b>Approval: </b>{{ markerData.approval }}</p>
                            <p><b>Status: </b>{{ markerData.status }}</p>
                            <p><b>More info: </b><a :href="getCustomerEditUrl(markerData.id)">{{ markerData.customer_name
                            }}</a></p>
                        </div>
                    </div>
                </GInfoWindow>
            </GMarker>
        </GMap>
    </div>
</template>
<script src="https://unpkg.com/vue3-google-map"></script>
  <script lang="ts">
  import { ref } from 'vue';
  import { GMap, GMarker, GInfoWindow } from 'vue3-google-map';
  
  export default {
    name: 'MapComponent',
    components: {
      GMap,
      GMarker,
      GInfoWindow,
    },
    setup() {
      const center = { lat: -1.292066, lng: 36.821945 };
      const typeMap = '{{ $typeMap }}';
      const markerIcon = '{{ asset('app-assets/images/pin.png') }}';
  
      const initialMarkers = [
        {
          position: {
            lat: -1.266096,
            lng: 36.7163152
          },
          id: 10,
          customer_name: 'new duka',
          account: null,
          approval: 'Approved',
          address: 'PPM8+MFW, Uthiru, Nairobi, , Kenya',
          contact_person: 'James Km',
          customer_group: 'Independent Network',
          price_group: null,
          route: null,
          status: 'Active',
          email: 'james@gmail.com',
          phone_number: '0794641666'
        }
      ];
  
      function mapClicked(event) {
        console.log(event.latLng.lat(), event.latLng.lng());
      }
  
      function markerClicked(markerData, index) {
        console.log(markerData.position.lat, markerData.position.lng);
      }
  
      function markerDragEnd(event, index) {
        console.log(event.latLng.lat(), event.latLng.lng());
      }
  
      function getCustomerEditUrl(id) {
        // Implement your logic to generate the customer edit URL
      }
  
      return {
        center,
        typeMap,
        markerIcon,
        initialMarkers,
        mapClicked,
        markerClicked,
        markerDragEnd,
        getCustomerEditUrl,
      };
    },
  };
  </script>
  