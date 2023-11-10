<template>
  <div
    :ref="'report-window-' + this.reportId"
    class="common-report-window"
    v-if="opened"
    v-show="!rolledDown"
    @drop="onDrop"
    @dragover.prevent
  >
    <div
      :ref="'report-window-wrapper-' + this.reportId"
      class="report-window-wrapper"
    >
      <v-toolbar
        :ref="'report-window-toolbar-' + this.reportId"
        theme="dark"
        class="w-100"
        :class="{'draggable': minimized}"
        :draggable="minimized"
        @dragstart="onDragStart"
      >
        <v-toolbar-title class="d-flex">{{ reportTitle }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn
            v-if="minimized"
            icon
            dark
            @click="expandModal"
            title="Увеличить панель отчета"
          >
            <v-icon>mdi-window-maximize</v-icon>
          </v-btn>
          <v-btn
            v-else
            icon
            dark
            @click="minimizeModal"
            title="Уменьшить панель отчета"
          >
            <v-icon>mdi-window-restore</v-icon>
          </v-btn>
          <v-btn
            icon
            dark
            @click="rollDownModal"
            title="Свернуть панель отчета"
          >
            <v-icon>mdi-window-minimize</v-icon>
          </v-btn>
          <v-btn
            icon
            dark
            @click="hideModal"
            title="Закрыть панель отчета"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card
        :ref="'report-window-card-' + this.reportId"
        class="report-window-card w-100"
      >
        <v-card-text
          :ref="'report-window-card-text-' + this.reportId"
          class="p-0 w-100 h-100"
        >
          <div
            class="report-main-content d-flex align-items-center"
            :ref="'report-window-card-main-content-' + this.reportId"
            :class="{
              'report-tabs-folded': showReportTabs && reportTabsFolded,
              'report-tabs-active': showReportTabs && !reportTabsFolded
            }"
            @drop.stop.prevent="onDropSplitter"
            @dragover.prevent
          >
            <div
              v-show="showPanel"
              class="content-panel h-100"
              :ref="'report-window-card-panel-' + this.reportId"
            >
              <v-card class="h-100">
                <v-toolbar>
                  <v-toolbar-title class="text-h6">Параметры отчета</v-toolbar-title>
                  <template #append>
                    <v-btn
                      icon="mdi-arrow-left"
                      title="Свернуть панель"
                      @click="togglePanel"
                    ></v-btn>
                  </template>
                </v-toolbar>
                <v-card-text class="p-0 h-100">
                  <div class="d-flex align-items-center flex-column p-3">
                    <div class="w-100 d-flex align-items-center">
                      <v-autocomplete
                        clearable
                        label="Выберите объект"
                        :items="dropdownObjects"
                        v-model="dropdownObjectId"
                        density="comfortable"
                        hide-details
                        item-title="name"
                        item-value="id"
                        no-data-text="Объекты отсутствуют"
                        class="objects"
                        @update:modelValue="onInputDropdownObject"
                      >
                        <template #prepend>Объект:</template>
                      </v-autocomplete>
                    </div>

                    <report-date-time-range-picker @period-changed="onPeriodChanged"></report-date-time-range-picker>

                    <v-btn
                      class="mt-4 w-100"
                      title="Выполнить"
                      @click="execReport"
                    >Выполнить</v-btn>
                  </div>
                </v-card-text>
              </v-card>
            </div>
            <div
              v-show="!showPanel"
              class="content-panel-folded h-100 cursor-pointer"
              @click="togglePanel"
              title="Развернуть панель"
            >
              <div class="title"><strong>Параметры отчета</strong></div>
            </div>
            <div
              class="content-splitter h-100"
              :class="{
                'draggable': showPanel,
                'cursor-pointer': !showPanel,
                'd-none': hiddenPanelSplitter,
              }"
              :title="showPanel ? 'Изменить размер панели' : 'Развернуть панель'"
              :draggable="showPanel"
              @dragstart="onDragStartPanel"
              @dblclick="togglePanel"
            >
              <div
                class="control cursor-pointer"
                :class="{'left': showPanel}"
                :title="showPanel ? 'Свернуть панель' : 'Развернуть панель'"
                @click="togglePanel"
              ></div>
            </div>
            <div class="content-map w-100 h-100">
              <app-map
                ref="reportMap"
                :messages="messages"
                :message-marker="messageMarker"
              ></app-map>
            </div>
          </div>
          <template v-if="showReportTabs">
            <div
              class="content-splitter horizontal w-100"
              :class="{
                  'draggable': showReportTabs && !reportTabsFolded,
                  'cursor-pointer': reportTabsFolded,
                }"
              :title="reportTabsFolded ? 'Изменить размер панели' : 'Развернуть панель'"
              :draggable="showReportTabs && !reportTabsFolded"
              @dragstart="onDragStartReportTabs"
              @dblclick="toggleReportTabs"
            >
              <div
                class="control horizontal cursor-pointer"
                :class="{
                    'top': reportTabsFolded,
                    'bottom': !reportTabsFolded,
                  }"
                :title="reportTabsFolded ? 'Свернуть панель' : 'Развернуть панель'"
                @click="toggleReportTabs"
              ></div>
            </div>
            <div
              v-if="reportTabsFolded"
              class="content-panel-folded horizontal w-100 cursor-pointer"
              @click="toggleReportTabs"
              title="Развернуть панель"
            >
              <div class="title d-flex align-items-center"><strong>Данные</strong></div>
            </div>
          </template>
          <div
            v-if="showReportTabs && !reportTabsFolded"
            :ref="'report-window-card-report-tabs-' + this.reportId"
            class="report-window-card-report-tabs"
            @drop="onDropReportTabs"
            @dragover.prevent
          >

            <v-tabs
              :ref="'report-window-card-report-tabs-w-window-' + this.reportId"
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
                :class="{'h-100': ['speed'].includes(item.key)}"
              >
                <v-card flat class="h-100">
                  <v-card-text class="p-0 h-100 d-flex">
                    <template v-if="item.key === 'statistics'">
                      <statistics-tab
                        :object-name="objectName"
                        :statistics="statistics"
                      ></statistics-tab>
                    </template>
                    <template v-else-if="item.key === 'speed'">
                      <speed-tab
                        :object-name="objectName"
                        :messages="messages"
                        :date-from="dateFrom"
                        :date-to="dateTo"
                        @select-message="onSelectMessage"
                      ></speed-tab>
                    </template>
                    <template v-else-if="item.key === 'messages'">
                      <messages-tab
                        :messages="messages"
                        @select-row="onSelectMessage"
                        @unselect-row="onUnselectMessage"
                      ></messages-tab>
                    </template>
                    <template v-else-if="item.key === 'stops-parkings'">
                      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                        <span>В разработке</span>
                      </div>
                    </template>
                    <template v-else-if="item.key === 'trips'">
                      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                        <span>В разработке</span>
                      </div>
                    </template>
                    <template v-else-if="item.key === 'events'">
                      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                        <span>В разработке</span>
                      </div>
                    </template>
                    <template v-else-if="item.key === 'sensors'">
                      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                        <span>В разработке</span>
                      </div>
                    </template>
                    <template v-else-if="item.key === 'lost-connections'">
                      <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                        <span>В разработке</span>
                      </div>
                    </template>
                  </v-card-text>
                </v-card>
              </v-window-item>
            </v-window>

          </div>
        </v-card-text>
      </v-card>
    </div>
  </div>
</template>

<script>

import AppMap from '@/js/components/AppMap.vue'
import StatisticsTab from '@/js/views/panel/user-object/panel/report/main-report/tabs/StatisticsTab.vue'
import MessagesTab from '@/js/views/panel/user-object/panel/report/main-report/tabs/MessagesTab.vue'
import ReportDateTimeRangePicker
  from '@/js/views/panel/user-object/panel/report/components/ReportDateTimeRangePicker.vue'
import appToast from '@/js/composables/toast-notification'
import SpeedTab from '@/js/views/panel/user-object/panel/report/main-report/tabs/SpeedTab.vue'

export default {
  name: 'AppMainReportModal',
  components: {
    SpeedTab,
    ReportDateTimeRangePicker, MessagesTab, StatisticsTab, AppMap
  },
  props: {
    reportId: String,
    showModal: Boolean,
    maximizeModal: Boolean,
    object: Object
  },
  emits: ['hide-modal', 'roll-down-modal', 'change-report-object'],
  watch: {
    maximizeModal: {
      handler(value) {
        this.rolledDown = value
      }
    }
  },
  data() {
    return {
      opened: false,
      messages: [],
      statistics: [],
      tab: null,
      tabs: [
        {
          key: 'statistics',
          label: 'Сатистика'
        },
        {
          key: 'speed',
          label: 'Скорость'
        },
        {
          key: 'messages',
          label: 'Сообщения по объектам'
        },
        {
          key: 'stops-parkings',
          label: 'Остановки и стоянки'
        },
        {
          key: 'trips',
          label: 'Поездки'
        },
        {
          key: 'events',
          label: 'События'
        },
        {
          key: 'sensors',
          label: 'Датчики'
        },
        {
          key: 'lost-connections',
          label: 'Потери связи'
        }
      ],
      dateFrom: null,
      dateTo: null,
      messageMarker: null,
      showReportTabs: false,
      reportTabsFolded: false,
      showPanel: true,
      hiddenPanelSplitter: false,
      rolledDown: false,
      minimized: false,
      startWindowY: null,
      startWindowHeight: null,
      offsetX: null,
      offsetY: null,
      dropdownObjects: [],
      dropdownObjectId: null,
      selectedObject: null,
      dragStartSplitterX: null,
      dragStartPanelWidth: null,
      dragStartReportTabsSplitterY: null,
      dragStartReportTabsHeight: null,
      dragStartReportTabsHeightChanged: false,
      dragReportTabsActive: false,
    }
  },
  computed: {
    objectName() {
      return this.selectedObject ? this.selectedObject.name : null
    },
    reportTitle() {
      return this.objectName ? `Общий отчет по «${ this.objectName }»` : 'Объект не выбран'
    },
  },
  setup() {
    const { toastWarning } = appToast()

    return {
      toastWarning,
    }
  },
  mounted() {
    this.opened = this.showModal
    this.selectedObject = this.object
    if (this.opened) {
      this.fetchObjectListForDropdown()
    }
  },
  methods: {
    fetchObjectListForDropdown() {
      axios.get(`/object/user-objects-for-dropdown`)
        .then(response => {
          this.dropdownObjects = response.data
          if (this.selectedObject) {
            this.dropdownObjectId = this.dropdownObjects.find(object => object.id === this.selectedObject.id).id
          }
        })
        .catch(error => console.log(error))
    },
    hideModal() {
      this.clearReportMapInfo()
      this.dateFrom = null
      this.dateTo = null
      this.showReportTabs = false
      this.reportTabsFolded = false
      this.opened = false
      this.selectedObject = null
      this.dropdownObjectId = null
      this.$emit('hide-modal', this.reportId)
    },
    expandModal() {
      this.minimized = false
      const parent = this.$refs['report-window-' + this.reportId]
      this.$refs['report-window-wrapper-' + this.reportId].style.width = `${parent.offsetWidth}px`
      this.$refs['report-window-wrapper-' + this.reportId].style.height = `${parent.offsetHeight}px`
      this.$refs['report-window-wrapper-' + this.reportId].style.top = 0
      this.$refs['report-window-wrapper-' + this.reportId].style.left = 0
    },
    minimizeModal() {
      this.minimized = true
      const parent = this.$refs['report-window-' + this.reportId]
      const width = parent.offsetWidth
      const height = parent.offsetHeight
      const x = width / 4
      const y = height / 4
      this.startWindowY = this.$refs['report-window-wrapper-' + this.reportId].getBoundingClientRect().bottom
      this.startWindowHeight = height - (y * 2)
      this.$refs['report-window-wrapper-' + this.reportId].style.width = `${width - (x * 2)}px`
      this.$refs['report-window-wrapper-' + this.reportId].style.height = `${this.startWindowHeight}px`
      this.$refs['report-window-wrapper-' + this.reportId].style.top = `${y}px`
      this.$refs['report-window-wrapper-' + this.reportId].style.left = `${x}px`
    },
    rollDownModal() {
      this.rolledDown = true
      this.$emit('roll-down-modal', this.reportId)
    },
    clearReportMapInfo() {
      this.messages = []
      this.statistics = []
      this.messageMarker = null
    },
    execReport() {
      if (!this.selectedObject) {
        alert('Объект не выбран')
        return false
      }
      if (
        this.selectedObject.equipments && this.selectedObject.equipments.length
          && this.selectedObject.equipments[0].imei
      ) {
        let params = ''
        this.clearReportMapInfo()
        if (this.dateFrom && this.dateTo) {
          params = new URLSearchParams({
            from: this.$moment(this.dateFrom).unix(),
            to: this.$moment(this.dateTo).unix(),
          }).toString()
        } else {
          this.toastWarning('Пожалуйста, заполните период отчета')
          return false
        }
        axios.get(`/object/${this.selectedObject.equipments[0].imei}/common-report/messages?${params}`)
          .then(response => this.messages = response.data)
          .catch(error => console.log(error))
        axios.get(`/object/${this.selectedObject.equipments[0].imei}/common-report/statistics?${params}`)
          .then(response => this.statistics = response.data)
          .catch(error => console.log(error))
          .finally(() => this.showReportTabs = true)
      } else {
        alert('У объекта не указан IMEI')
      }
    },
    onInputDropdownObject() {
      if (this.selectedObject) {
        if (this.dropdownObjectId) {
          if (this.selectedObject.id !== this.dropdownObjectId) {
            axios.get(`/object/user-objects/${this.dropdownObjectId}`)
              .then(response => {
                this.selectedObject = response.data
                this.emitChangeReportObject()
              })
              .catch(error => console.log(error))
          }
        } else {
          this.dropdownObjectId = this.selectedObject.id
          this.emitChangeReportObject()
        }
      } else {
        axios.get(`/object/user-objects/${this.dropdownObjectId}`)
          .then(response => {
            this.selectedObject = response.data
            this.emitChangeReportObject()
          })
          .catch(error => console.log(error))
      }
    },
    emitChangeReportObject() {
      this.clearReportMapInfo()
      this.showReportTabs = false
      this.reportTabsFolded = false
      this.$emit('change-report-object', {object: this.selectedObject, reportId: this.reportId})
    },
    onSelectMessage(data) {
      this.messageMarker = data
    },
    onUnselectMessage() {
      this.messageMarker = null
    },
    togglePanel() {
      this.showPanel = !this.showPanel
    },
    onDragStart(event) {
      if (this.minimized) {
        const rect = event.target.getBoundingClientRect()
        this.offsetX = event.clientX - rect.x
        this.offsetY = event.clientY - rect.y + 50
        event.dataTransfer.effectAllowed = 'move'
        event.dataTransfer.setData('type', 'report-window')
      }
    },
    onDrop(event) {
      if (!this.dragReportTabsActive) {
        const diffX = event.clientX - this.offsetX
        const diffY = event.clientY - this.offsetY
        const $windowWrapper = this.$refs['report-window-wrapper-' + this.reportId]
        const rect = $windowWrapper.getBoundingClientRect()
        const positionX = rect.right + (diffX - rect.left)
        let left = diffX
        let top = diffY
        if (positionX >= this.$refs['report-window-' + this.reportId].offsetWidth) {
          left = this.$refs['report-window-' + this.reportId].offsetWidth - $windowWrapper.offsetWidth
        } else if (diffX < 0) {
          left = 0
        }
        if (this.startWindowY < event.clientY + this.startWindowHeight - 30) {
          top = this.startWindowY - (this.startWindowHeight + 50)
        } else if (diffY < 0) {
          top = 0
        }
        this.$refs['report-window-wrapper-' + this.reportId].style.left = left + 'px'
        this.$refs['report-window-wrapper-' + this.reportId].style.top = top + 'px'
      }
    },
    onPeriodChanged(data) {
      this.dateFrom = data.from
      this.dateTo = data.to
    },
    onDragStartPanel(event) {
      this.dragStartSplitterX = event.clientX
      this.dragStartPanelWidth = this.$refs['report-window-card-panel-' + this.reportId].getBoundingClientRect().width
      event.dataTransfer.setData('type', 'report-panel')
    },
    onDropSplitter(event) {
      const dataTransferType = event.dataTransfer.getData('type')
      if (dataTransferType === 'report-panel') {
        const diff = this.dragStartSplitterX - event.clientX
        this.$refs['report-window-card-panel-' + this.reportId].style.width = `${this.dragStartPanelWidth - diff < 500
          ? 500 : this.dragStartPanelWidth - diff}px`
      }
      if (dataTransferType === 'report-tabs') {
        const diff = this.dragStartReportTabsSplitterY - event.clientY
        if (this.dragStartReportTabsHeightChanged) {
          const reportTabsHeight = this.$refs['report-window-card-report-tabs-' + this.reportId].getBoundingClientRect().height
          const mainContentHeight = this.$refs['report-window-card-main-content-' + this.reportId].getBoundingClientRect().height
          if (mainContentHeight >= 0) {
            this.$refs['report-window-card-report-tabs-' + this.reportId].style.height = `${reportTabsHeight + diff}px`
            this.$refs['report-window-card-main-content-' + this.reportId].style.height = `${mainContentHeight - diff}px`
          } else {
            this.$refs['report-window-card-report-tabs-' + this.reportId].style.height = '50%'
            this.$refs['report-window-card-main-content-' + this.reportId].style.height = '50%'
          }
          this.hiddenPanelSplitter = event.layerY <= 35
        } else {
          const mainContentHeight = this.$refs['report-window-card-main-content-' + this.reportId].getBoundingClientRect().height
          if (mainContentHeight >= 0) {
            this.$refs['report-window-card-report-tabs-' + this.reportId].style.height = `calc(50% + ${diff}px)`
            this.$refs['report-window-card-main-content-' + this.reportId].style.height = `calc(50% - ${diff}px)`
            this.dragStartReportTabsHeightChanged = true
          }
          this.hiddenPanelSplitter = event.layerY <= 35
        }
        this.dragReportTabsActive = false
      }
    },
    toggleReportTabs() {
      this.reportTabsFolded = !this.reportTabsFolded
      if (this.reportTabsFolded) {
        const mainContentHeight = this.$refs['report-window-card-main-content-' + this.reportId].getBoundingClientRect().height
        this.$refs['report-window-card-report-tabs-' + this.reportId].style.height = `${mainContentHeight + 30}px`
        this.$refs['report-window-card-main-content-' + this.reportId].style.height = `calc(100% - 35px)`
      } else {
        this.$refs['report-window-card-main-content-' + this.reportId].style.height = `50%`
      }
    },
    onDragStartReportTabs(event) {
      this.dragStartReportTabsSplitterY = event.clientY
      this.dragStartReportTabsHeight =
        this.$refs['report-window-card-report-tabs-' + this.reportId].getBoundingClientRect().height
      this.dragReportTabsActive = true
      event.dataTransfer.setData('type', 'report-tabs')
    },
    onDropReportTabs(event) {
      const diff = Math.abs(this.dragStartReportTabsSplitterY - event.clientY)
      const mainContentHeight = this.$refs['report-window-card-main-content-' + this.reportId].getBoundingClientRect().height
      if (mainContentHeight >= 0) {
        this.$refs['report-window-card-report-tabs-' + this.reportId].style.height = `calc(100% - ${mainContentHeight + diff + 6}px)`
        this.$refs['report-window-card-main-content-' + this.reportId].style.height = `${mainContentHeight + diff}px`
        this.$refs['report-window-card-' + this.reportId].$el.style.height = `calc(100% + 49px)`
        this.dragStartReportTabsHeightChanged = true
      }
      this.dragReportTabsActive = false
      this.hiddenPanelSplitter = mainContentHeight + diff <= 35
    },
  }
}
</script>

<style lang='scss' scoped>

label {
  font: normal 12px/14px tahoma, arial, verdana, sans-serif;
}

.v-window {
  height: calc(100% - 48px);
}

.content-panel {
  .v-card {
    min-width: 500px;
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
  &.horizontal {
    padding: 4px 5px 4px 5px;
    height: 30px;
    .title {
      transform: unset;
      font-size: 11px;
      font-weight: bold;
      font-family: tahoma, arial, verdana, sans-serif;
      line-height: 15px;
    }
  }
  .title {
    transform: rotate(90deg);
    transform-origin: 0 15px;
    height: 20px;
    width: 132px;
  }
}
.content-splitter {
  background-color: #d8d8d8;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  min-width: 5px;
  max-width: 5px;
  &.draggable {
    cursor: col-resize;
  }
  &.horizontal {
    min-width: unset;
    max-width: unset;
    min-height: 5px;
    max-height: 5px;
    &.draggable {
      cursor: row-resize;
    }
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
    &.horizontal {
      width: 35px;
      height: 5px;
      &.top {
        background-image: url('@/img/mini-top.png');
      }
      &.bottom {
        background-image: url('@/img/mini-bottom.png');
      }
    }
  }
}

.report-window-card {
  height: 100%;
}

.common-report-window {
  width: 100%;
  height: calc(100% - 160px);
  top: 50px;
  position: absolute;
  .report-window-wrapper {
    position: relative;
    height: 100%;
  }
  .report-main-content {
    height: 100%;
    &.report-tabs-folded {
      height: calc(100% - 30px);
    }
    &.report-tabs-active {
      height: 50%;
    }
  }
  .report-window-card-report-tabs {
    height: 50%;
  }
}

.v-toolbar {
  &.draggable {
    cursor: grab;
  }
}

</style>
