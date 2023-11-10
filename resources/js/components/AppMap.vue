<template>
  <div style="height:100%; width:100%">
    <button @click="Test">
                Загрузить объекты
                </button>
    <l-map
      ref="map"
      :useGlobalLeaflet="false"
      v-model:zoom="zoom"
      :min-zoom="2"
      :max-zoom="12"
      @ready="onMapReady"
    >
      <l-tile-layer
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        layer-type="base"
        name="OpenStreetMap"
      ></l-tile-layer>
      <template v-if="objects.length">
        <template v-for="object in objects">
          <l-marker
            v-if="object.lat && object.lon"
            :lat-lng="[object.lat, object.lon]"
          >
            <l-icon :icon-size="[0, 0]">
              <div class="d-flex align-center flex-column">
                <img src="@/img/marker.png">
                <div class="marker-label">{{ object.name }}</div>
              </div>
            </l-icon>
          </l-marker>

        </template>
      </template>
      <template v-if="messages.length">
        <l-polyline
          :lat-lngs="polyline.latlngs"
          :color="polyline.color"
        ></l-polyline>
        <template v-for="marker in polyline.markers">
          <l-marker
            v-if="marker.start"
            :lat-lng="marker.latLon"
          >
            <l-icon
              :icon-anchor="[6, 23]"
              :icon-size="[0, 0]"
            >
              <img src="@/img/start.png">
            </l-icon>
          </l-marker>
          <l-marker
            v-else-if="marker.finish"
            :lat-lng="marker.latLon"
          >
            <l-icon
              :icon-anchor="[6, 23]"
              :icon-size="[0, 0]"
            >
              <img src="@/img/finish.png">
            </l-icon>
          </l-marker>
        </template>
      </template>
      <template v-if="messageMarker">
        <l-marker :lat-lng="[messageMarker.lat, messageMarker.lon]">
          <l-icon
            :icon-anchor="[10, 24]"
            :icon-size="[0, 0]"
          >
            <img src="@/img/coords.png">
          </l-icon>
        </l-marker>

      </template>
    </l-map>
  </div>
</template>

<script>
import 'leaflet/dist/leaflet.css'
import { LMap, LTileLayer, LControlAttribution, LMarker, LIcon, LPolyline } from '@vue-leaflet/vue-leaflet'

export default {
  name: 'AppMap',
  components: {
    LMap,
    LTileLayer,
    LControlAttribution,
    LMarker,
    LIcon,
    LPolyline
  },
  props: {
    objects: {
      type: Array,
      default: () => ([])
    },
    moveCenterTo: Object,
    messages: {
      type: Array,
      default: () => ([])
    },
    messageMarker: Object
  },
  watch: {
    moveCenterTo: {
      handler(event) {
        if (event) {
          this.moveMapCenterTo(event)
        }
      }
    },
    messages: {
      handler(event) {
        if (event) {
          this.messagesToMap()
        }
      }
    },
    messageMarker: {
      handler(event) {
        if (event) {
          this.moveMapCenterTo(event)
        }
      }
    },
  },
  data() {
    return {
      zoom: 7,
      prefix: null,
      markerLatLng: [47.313220, -1.319482],
      center: [55.751244, 37.618423],
      polyline: {
        latlngs: [],
        markers: [],
        color: 'blue'
      },
    };
  },
  methods: {
    onMapReady(event) {
      event.attributionControl._container.remove()
      this.$refs.map.leafletObject.panTo(this.center)
    },
    moveMapCenterTo(coords) {
      if (coords && coords.lat && coords.lon) {
        this.$refs.map.leafletObject.invalidateSize()
        this.$refs.map.leafletObject.panTo([coords.lat, coords.lon])
      }
    },
    messagesToMap() {
      const messagesLen = this.messages.length
      if (messagesLen) {
        this.polyline.latlngs = []
        this.polyline.markers = []
        this.messages.map((message, index) => {
          const coord = [message.lat, message.lon]
          this.polyline.latlngs.push(coord)
          this.polyline.markers.push({
            latLon: coord,
            start: index === messagesLen - 1,
            finish: !index
          })
        })
        this.$refs.map.leafletObject.invalidateSize()
        this.$refs.map.leafletObject.fitBounds(this.polyline.latlngs)
      }
    },
    Test(){
        console.log(this.objects)
    }
  },
}
</script>

<style lang='scss' scoped>
.leaflet-marker-icon {
  //display: flex;
  //align-items: center;
  //width: 0;
  //height: 0;
  .marker-label {
    min-width: max-content;
    font-family: tahoma, arial, verdana, sans-serif;
    font-size: 11px;
    font-weight: bold;
    color: red;
    text-shadow:
      -1px 0 0 white,
      1px 0 0 white,
      0 -1px 0 white,
      0 1px 0 white;
  }
}
</style>
