<template>
  <user-nav @main-menu-report-click="onMainMenuReportClick"></user-nav>
  <button @click="Test">
                Загрузить объекты
                </button>

  <div
    class="content d-flex align-items-start"
    @drop="onDropSplitter"
    @dragover.prevent
  >
    <div
      v-show="showPanel"
      class="content-panel h-100"
      ref="panel"
    >
      <v-card class="h-100">
        <v-toolbar theme="dark">
          <v-toolbar-title class="text-h6">Все объекты</v-toolbar-title>
          <template v-slot:append>
            <v-btn
              icon="mdi-arrow-left"
              title="Свернуть панель"
              @click="togglePanel"
            ></v-btn>
          </template>
        </v-toolbar>
        <v-card-text class="p-0">
          <v-tabs
            v-model="tab"
            fixed-tabs
          >
            <v-tab
              v-for="item in tabs"
              :key="item.key"
              :value="item"
            >
              {{ item.label }}
            </v-tab>
          </v-tabs>

          <v-window v-model="tab">
            <v-window-item
              v-for="item in tabs"
              :key="item.key"
              :value="item"
            >
              <v-card flat>
                <v-card-text class="p-0">
                  <template v-if="item.key === 'objects'">
                    <object-list-tab
                      @map-objects-changed="onMapObjectsChanged"
                      @pan-to-object="onPanToObject"
                      @open-common-report-window="openCommonReportModal"
                    ></object-list-tab>
                  </template>
                  <template v-else>
                    <object-group-list-tab></object-group-list-tab>
                  </template>
                </v-card-text>
              </v-card>
            </v-window-item>
          </v-window>
        </v-card-text>
      </v-card>
    </div>
    <div
      v-show="!showPanel"
      class="content-panel-folded h-100 cursor-pointer"
      @click="togglePanel"
      title="Развернуть панель"
    >
      <div class="title"><strong>Все объекты</strong></div>
    </div>
    <div
      class="content-splitter h-100"
      :class="{
        'draggable': showPanel,
        'cursor-pointer': !showPanel,
      }"
      :title="showPanel ? 'Изменить размер панели' : 'Развернуть панель'"
      :draggable="showPanel"
      @dragstart="onDragStartPanel"
      @dblclick="togglePanel"
    >
      <div
        class="control cursor-pointer"
        :class="{
          'left': showPanel
        }"
        :title="showPanel ? 'Свернуть панель' : 'Развернуть панель'"
        @click="togglePanel"
      ></div>
    </div>
    <div class="content-map w-100 h-100">
      <app-map
        class="position-sticky"
        :objects="mapObjects"
        :move-center-to="mapPanToProps"
      ></app-map>
    </div>
  </div>

  <template
    v-if="reports.length"
    v-for="report in reports"
  >
    <app-main-report-modal
      :report-id="report.id"
      :show-modal="report.show"
      :object="report.object"
      :maximize-modal="report.rolledDown"
      @hide-modal="onHideCommonReportModal"
      @roll-down-modal="onRollDownReportModal"
      @change-report-object="onChangeReportObject"
    ></app-main-report-modal>
  </template>

  <report-toolbar
    :reports="reports"
    @open-report-window="onOpenReportWindow"
    @hide-all-reports="onHideAllReports"
  ></report-toolbar>
</template>

<script>
import UserNav from '@/js/components/UserNav.vue'
import AppMap from '@/js/components/AppMap.vue'
import ObjectListTab from '@/js/views/panel/user-object/panel/object-list-tab/ObjectListTab.vue'
import ObjectGroupListTab from '@/js/views/panel/user-object/panel/object-group-list-tab/ObjectGroupListTab.vue'
import ReportToolbar from '@/js/views/panel/user-object/ReportToolbar.vue'
import AppMainReportModal from '@/js/views/panel/user-object/panel/report/main-report/AppMainReportModal.vue'

export default {
  name: 'UserObject',
  components: {
    AppMainReportModal, ReportToolbar, ObjectGroupListTab, ObjectListTab, AppMap, UserNav
  },
  data() {
    return {
        arr_data: [],
      tab: null,
      tabs: [
        {
          key: 'objects',
          label: 'Объекты'
        },
        {
          key: 'objects-groups',
          label: 'Группы объектов'
        }
      ],
      mapObjects: [],
      showPanel: true,
      mapPanToProps: null,
      reports: [],
      dragStartSplitterX: null,
      dragStartPanelWidth: null,
      username: ''
    }
  },
  methods: {
    onMapObjectsChanged(event) {
      this.mapObjects = event
      console.log(event)
    },
    onPanToObject(event) {
      if (event && event.lat && event.lon) {
        this.mapPanToProps = {
          lat: event.lat,
          lon: event.lon
        }
      }
    },
    togglePanel() {
      this.showPanel = !this.showPanel
    },
    openCommonReportModal(object) {
      this.reports.push({
        id: this.generateReportId(),
        object: object,
        show: true,
        rolledDown: false,
        title: this.getReportTitle(object.name)
      })
    },
    onHideCommonReportModal(reportId) {
      const reportIdx = this.reports.findIndex(report => report.id === reportId)
      this.reports.splice(reportIdx, 1)
    },
    onRollDownReportModal(reportId) {
      const reportIdx = this.reports.findIndex(report => report.id === reportId)
      if (reportIdx > -1) {
        this.reports[reportIdx].rolledDown = true
      }
    },
    onOpenReportWindow(reportId) {
      this.reports.map(report => report.rolledDown = report.id === reportId ? !report.rolledDown : true)
    },
    onHideAllReports() {
      this.reports.map(report => report.rolledDown = true)
    },
    onChangeReportObject(data) {
      const idx = this.reports.findIndex(report => report.id === data.reportId)
      if (idx > -1) {
        this.reports[idx].object = data.object
        this.reports[idx].title = this.getReportTitle(data.object.name)
      }
    },
    getReportTitle(objectName = null) {
      return objectName ? `Общий отчет по «${ objectName }»` : 'Общий отчет по объекту'
    },
    onMainMenuReportClick() {
      this.reports.push({
        id: this.generateReportId(),
        object: null,
        show: true,
        rolledDown: false,
        title: this.getReportTitle()
      })
    },
    generateReportId() {
      return (Math.random()).toString(36)
    },
    onDragStartPanel(event) {
      this.dragStartSplitterX = event.clientX
      this.dragStartPanelWidth = this.$refs.panel.getBoundingClientRect().width
    },
    onDropSplitter(event) {
      const diff = this.dragStartSplitterX - event.clientX
      this.$refs.panel.style.width = `${this.dragStartPanelWidth - diff < 400
        ? 400 : this.dragStartPanelWidth - diff}px`
    },
    Test(){
        console.log('test')
        console.log(this.mapObjects)
        let fData = new FormData()
        fData.append('search', '')
        axios.post('/tracker/get')
        .then(response => {
          let data = response.data
          console.log(response.data)
          if (data.result) {
            console.log(data)
            this.arr_data = []
            for (let i in data['data']) {
              let item = data['data'][i]
              this.arr_data.push(item)
            }
          }
        })
    },
    loadUserName() {
      let user = localStorage.getItem('user')
      user = user ? JSON.parse(user) : null
      this.userName = user && user.name ? user.name : null
    },
  }
}
</script>

<style lang='scss' scoped>
.content {
  height: calc(100% - 96px);
  overflow: hidden;
  .content-panel {
    .v-card {
      min-width: 400px;
      width: inherit;
      border-radius: 0;
    }
  }
  .content-panel-folded {
    padding: 10px;
    border-color: #bcb0b0;
    background-image: none;
    background-color: #d8d8d8;
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e6e6e6), color-stop(100%, #efefef));
    background-image: -moz-linear-gradient(to top, #e6e6e6, #efefef);
    background-image: -o-linear-gradient(to top, #e6e6e6, #efefef);
    background-image: linear-gradient(to top, #e6e6e6, #efefef);
    width: 30px;
    .title {
      transform: rotate(90deg);
      transform-origin: 0 18px;
      height: 20px;
      width: 100px;
    }
  }
  .content-splitter {
    background-color: #d8d8d8;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 10px;
    min-width: 8px;
    max-width: 8px;
    &.draggable {
      cursor: col-resize;
    }
    .control {
      width: 5px;
      height: 35px;
      opacity: 0.7;
      margin-left: -1px;
      &.left {
        background-image: url('@/img/mini-left.png');
      }
      &:not(.left) {
        background-image: url('@/img/mini-right.png');
      }
      &:hover {
        opacity: 1;
      }
    }
  }
}
</style>
