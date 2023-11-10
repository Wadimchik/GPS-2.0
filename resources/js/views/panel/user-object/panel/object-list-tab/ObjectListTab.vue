<template>
  <v-toolbar height="26" class="pt-1 pb-1 pr-2 d-flex">
    <div class="search-wrapper">
      <strong class="search-title">Поиск объектов:</strong>
      <input
        type="text"
        class="search-input"
        v-model="objectFilter"
        @keyup="onSearch"
      >
      <div class="separator"></div>
      <div class="panel d-flex align-items-center justify-content-center">
        <img
          :src="showAllHiddenObjectsBtnIcon"
          :title="showAllHiddenObjectsBtnTitle"
          class="show-all-hidden-objects"
          :class="{'active': showAllHiddenObjects}"
          @click="onShowAllHiddenObjectsClick"
        >
      </div>
      <div class="separator"></div>
      <div class="panel d-flex align-items-center justify-content-center">
        <v-menu
          anchor="bottom end"
          rounded
          class="context-menu"
          open-on-click
          close-on-back
          close-on-content-click
        >
          <template #activator="{ props }">
            <div
              class="d-flex align-items-center"
              v-bind="props"
              @click.stop
            >
              <img src="@/img/common/check-all.png">
              <img src="@/img/arrow-down.png">
            </div>
          </template>
          <v-list class="context-menu-list p-0">
            <div class="context-menu-separator h-100"></div>
            <div class="pt-1 pb-1">
              <v-list-item
                v-for="(item, index) in items"
                :key="index"
                class="d-flex align-items-center cursor-pointer"
                @click="onMultipleObjectsActionsContextMenuClick(item)"
              >
                <template #prepend="{ isActive }">
                  <div class="icon-wrapper">
                    <img :src="item.icon">
                  </div>
                </template>
                <template #default="{ isActive }">
                  <v-list-item-title :title="item.title">{{ item.text }}</v-list-item-title>
                </template>
              </v-list-item>
            </div>
          </v-list>
        </v-menu>
      </div>
      <div class="separator"></div>
      <div class="panel d-flex align-items-center justify-content-center">
        <v-menu
          anchor="bottom end"
          rounded
          class="context-menu"
          open-on-click
          close-on-back
          :close-on-content-click="false"
          location="right"
        >
          <template #activator="{ props }">
            <div
              class="d-flex align-items-center"
              v-bind="props"
              @click.stop
            >
              <img
                src="@/img/common/menu-vertical.png"
                title="Настройки отображения"
              >
            </div>
          </template>
          <v-list class="context-menu-list p-0">
            <div class="context-menu-separator h-100"></div>
            <div class="pt-1 pb-1">
              <v-list-item
                v-for="(item, index) in visibilitySettingsItems"
                :key="index"
                class="d-flex align-items-center cursor-pointer"
                @click="onListSettingsContextMenuClick(item)"
              >
                <template #prepend="{ isActive }">
                  <div class="check-box-wrapper d-flex align-center">
                    <input
                      class="form-check-input cursor-pointer"
                      type="checkbox"
                      v-model="item.checked"
                    >
                  </div>
                </template>
                <template #default="{ isActive }">
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </template>
              </v-list-item>
            </div>
          </v-list>
        </v-menu>
      </div>
    </div>
  </v-toolbar>
  <v-table density="compact" class="table">
    <thead>
      <tr>
        <th class="pr-0">
          <input
            type="checkbox"
            v-model="selectAll"
            class="form-check-input cursor-pointer"
            :title="selectAllTitle"
            @change="onChangeSelectAll"
          >
        </th>
        <th
          v-if="showGlobeIconCell"
          class="pr-0"
        ></th>
        <th
          v-if="showObjectNameCell"
          class="text-left"
        >Название</th>
        <th v-if="showObjectStatusesCell"></th>
      </tr>
    </thead>
    <tbody>
      <template v-if="objectsListIsEmpty">
        <tr>
          <td
            :colspan="tbodyHeaderCellCollSpan"
            class="text-center"
          >
            <strong>Список пуст</strong>
          </td>
        </tr>
      </template>
      <template v-else>
        <template v-for="object in objects">
          <tr
            v-if="object.visible"
            :key="object.name"
            class="cursor-pointer object-row"
            :class="{
              'active-row': selectedRows.find(row => row.id === object.id)
            }"
            @click="onRowClick(object)"
          >
            <object-list-tab-item
              :object="object"
              :list-settings="userObjectListSettings"
              @globe-click="onGlobeClick"
              @object-targeting-click="onObjectTargetingClick"
              @menu-report-click="onMenuReportItemClick"
            ></object-list-tab-item>
          </tr>
        </template>
      </template>
    </tbody>
  </v-table>

</template>

<script>
import axios from 'axios'
import ObjectListTabItem from '@/js/views/panel/user-object/panel/object-list-tab/ObjectListTabItem.vue'
import {computed, ref} from 'vue'
import appToast from '@/js/composables/toast-notification'

export default {
  name: 'ObjectListTab',
  components: {ObjectListTabItem},
  setup() {
    const selectAll = ref(false)
    const selectAllTitle = computed(() => selectAll.value ? 'Снять выделение' : 'Выбрать всех')
    const { toastWarning } = appToast()

    return {
      selectAll,
      selectAllTitle,
      toastWarning
    }
  },
  emits: ['map-objects-changed', 'pan-to-object', 'open-common-report-window'],
  data() {
    return {
      objects: [],
      selectedRows: [],
      mapObjects: [],
      objectFilter: null,
      refreshTargetsInterval: null,
      showAllHiddenObjects: false,
      items: [
        {
          text: 'Отобразить на карте',
          title: 'Отобразить на карте все отмеченные объекты',
          type: 'show-checked-objects-on-map',
          icon: new URL('@/img/objects/globe-active.png', import.meta.url)
        },
        {
          text: 'Прекратить отображение на карте',
          title: 'Прекратить отображение на карте всех отмеченных объектов',
          type: 'hide-checked-objects-on-map',
          icon: new URL('@/img/objects/globe-inactive.png', import.meta.url)
        },
        {
          text: 'Скрыть из списка',
          title: 'Скрыть из списка все отмеченные объекты',
          type: 'hide-checked-objects-on-list',
          icon: new URL('@/img/common/hide-eye.png', import.meta.url)
        },
        {
          text: 'Показать в списке',
          title: 'Показать в списке все отмеченные объекты',
          type: 'show-checked-objects-on-list',
          icon: new URL('@/img/common/eye.png', import.meta.url)
        },
      ],
      visibilitySettingsItems: [
        {
          text: 'Отображение на карте',
          type: 'show_on_map_action_is_visible',
          checked: false,
        },
        {
          text: 'Название объекта',
          type: 'object_name_is_visible',
          checked: false,
        },
        {
          text: 'Состояние объекта / Скорость',
          type: 'object_state_info_is_visible',
          checked: false,
        },
        {
          text: 'Последнее сообщение / Число спутников',
          type: 'last_message_info_is_visible',
          checked: false,
        },
        {
          text: 'Отслеживание объектов',
          type: 'target_on_action_is_visible',
          checked: false,
        },
        // {
        //   text: 'Сообщения от спящего блока',
        //   type: 'sleep-object-messages'
        // },
        // {
        //   text: 'Радиозакладки',
        //   type: 'radio-bookmarks'
        // },
        {
          text: 'Управление объектами',
          type: 'objects_managing_is_visible',
          checked: false,
        },
        {
          text: 'Отчеты',
          type: 'reports_is_visible',
          checked: false,
        },
        {
          text: 'Настройки объектов',
          type: 'objects_settings_is_visible',
          checked: false,
        },
      ],
      userObjectListSettings: null,
    }
  },
  computed: {
    objectsListIsEmpty() {
      return !this.objects.length || !this.objects.find(object => object.visible)
    },
    showAllHiddenObjectsBtnIcon() {
      return this.showAllHiddenObjects
        ? new URL('@/img/common/hide-eye.png', import.meta.url).href
        : new URL('@/img/common/eye.png', import.meta.url).href
    },
    showAllHiddenObjectsBtnTitle() {
      return this.showAllHiddenObjects ? 'Скрыть все невидимые объекты' : 'Показать все скрытые объекты'
    },
    tbodyHeaderCellCollSpan() {
      let columnStatusesCount = 0
      let otherColumnsCount = 0
      if (this.userObjectListSettings) {
        const columnStatusesKeys = [
          'objects_managing_is_visible', 'reports_is_visible', 'objects_settings_is_visible',
          'radio_bookmarks_is_visible', 'sleep_object_messages_is_visible', 'target_on_action_is_visible',
          'last_message_info_is_visible', 'object_state_info_is_visible'
        ]
        const otherColumns = ['show_on_map_action_is_visible', 'object_name_is_visible']
        Object.keys(this.userObjectListSettings).map(column => {
          if (this.userObjectListSettings[column]) {
            if (otherColumns.includes(column)) {
              otherColumnsCount += 1
            }
            if (columnStatusesKeys.includes(column) && !columnStatusesCount) {
              columnStatusesCount += 1
            }
          }
        })
      }
      return this.userObjectListSettings ? 1 + columnStatusesCount + otherColumnsCount : 4
    },
    showGlobeIconCell() {
      return this.userObjectListSettings ? this.userObjectListSettings.show_on_map_action_is_visible : true
    },
    showObjectNameCell() {
      return this.userObjectListSettings ? this.userObjectListSettings.object_name_is_visible : true
    },
    showObjectStatusesCell() {
      if (this.userObjectListSettings) {
        const columnStatusesKeys = [
          'objects_managing_is_visible', 'reports_is_visible', 'objects_settings_is_visible',
          'radio_bookmarks_is_visible', 'sleep_object_messages_is_visible', 'target_on_action_is_visible',
          'last_message_info_is_visible', 'object_state_info_is_visible'
        ]
        let columnStatusesCount = 0
        Object.keys(this.userObjectListSettings).map(column => {
          if (this.userObjectListSettings[column]) {
            if (columnStatusesKeys.includes(column) && !columnStatusesCount) {
              columnStatusesCount += 1
            }
          }
        })
        return !!columnStatusesCount
      }
      return true
    },
  },
  mounted() {
    this.fetchUserObjectListSettings()
    this.fetchObjects()
    this.refreshTargetsInterval = setInterval(this.refreshTargets, 5000)
  },
  unmounted() {
    clearInterval(this.refreshTargetsInterval)
    this.refreshTargetsInterval = null
  },
  methods: {
    fetchUserObjectListSettings() {
      axios.get(`/user-object-list-settings`)
        .then(response => {
          this.userObjectListSettings = response.data ? response.data : null
          this.visibilitySettingsItems.map(
            setting => setting.checked = !this.userObjectListSettings || !!this.userObjectListSettings[setting.type]
          )
        })
        .catch(error => console.log(error))
    },
    fetchObjects() {

      axios.get(`/object/user-objects`)
        .then(response => {
          this.objects = response.data
          this.objects.map(object => {
            console.log(object)
            if(object.user_name){
                object.visible = true
                const mapObject = {name: object.name, object_id: object.id}
                this.mapObjects.push(mapObject)
                  this.emitMapObjectsChanged()
                  this.emitPenToObject(mapObject)
            }
            else{
                object.visible = false
            }
            object.checked = false
            if (object.user_object) {
              if (object.user_object.show_on_map || object.user_object.target_on) {
                if (object.equipments && object.equipments[0] && object.equipments[0].last_message) {
                  const mapObject = {...object.equipments[0].last_message, name: object.name, object_id: object.id}
                  this.mapObjects.push(mapObject)
                  this.emitMapObjectsChanged()
                  this.emitPenToObject(mapObject)
                }
              }
              object.visible = object.user_object.show_in_list
            }
          })
        })
        .catch(error => console.log(error))
        console.log(this.objects)
        console.log(this.mapObjects)
    },
    refreshTargets() {
      const targets = this.objects.filter(object => object.user_object && object.user_object.target_on)
      if (targets && targets.length) {
        const ids = targets.map(target => target.id).join(',')
        axios.get(`/object/user-objects?targets=` + ids)
          .then(response => {
            let latestMsg = null
            if (response.data && response.data.length) {
              response.data.map(object => {
                const idx = this.objects.findIndex(item => item.id === object.id)
                if (idx > -1) {
                  this.refreshObjectInfo(idx, object)
                  if (object.equipments && object.equipments[0] && object.equipments[0].imei) {
                    const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
                    if (mapObjectIdx > -1) {
                      const prevMsgId = this.mapObjects[mapObjectIdx].id
                      if (prevMsgId < object.equipments[0].last_message.id) {
                        this.mapObjects[mapObjectIdx] = {
                          ...object.equipments[0].last_message, name: object.name, object_id: object.id
                        }
                        if (!latestMsg) {
                          latestMsg = {
                            time_diff: object.equipments[0].last_message.time_diff,
                            data: this.mapObjects[mapObjectIdx]
                          }
                        } else {
                          latestMsg = object.equipments[0].last_message.time_diff < latestMsg.time_diff
                            ? object.equipments[0].last_message.time_diff : latestMsg.time_diff
                        }
                      }
                    }
                  }
                }
              })
              if (latestMsg) {
                this.emitMapObjectsChanged()
                this.emitPenToObject(latestMsg.data)
              }
            }
          })
          .catch(error => console.log(error))
      }
    },
    onRowClick(item) {
      const objectIdIdx = this.selectedRows.findIndex(row => row.id === item.id)
      if (objectIdIdx > -1) {
        this.selectedRows.splice(objectIdIdx, 1)
        if (!item.user_object || (!item.user_object.show_on_map && !item.user_object.target_on)) {
          const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === item.id)
          if (mapObjectIdx > -1) {
            this.mapObjects.splice(mapObjectIdx, 1)
            this.emitMapObjectsChanged()
          }
        }
      } else {
        this.selectedRows.push(item)
        if (item.equipments && item.equipments[0] && item.equipments[0].last_message) {
          const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === item.id)
          const mapObject = {...item.equipments[0].last_message, name: item.name, object_id: item.id}
          if (mapObjectIdx > -1) {
            this.mapObjects[mapObjectIdx] = mapObject
          } else {
            this.mapObjects.push(mapObject)
          }
          this.emitMapObjectsChanged()
          this.emitPenToObject(mapObject)
        }
      }
    },
    onGlobeClick(object) {
      if (object.user_object) {
        const show = !object.user_object.show_on_map
        this.changeShowOnMapProperty(object, show)
        if (show) {
          if (object.equipments && object.equipments[0] && object.equipments[0].imei) {
            const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
            const mapObject = {...object.equipments[0].last_message, name: object.name, object_id: object.id}
            if (mapObjectIdx > -1) {
              this.emitPenToObject(mapObject)
            } else {
              this.mapObjects.push(mapObject)
              this.emitMapObjectsChanged()
              this.emitPenToObject(mapObject)
            }
          }
        } else if (!object.user_object.target_on && this.selectedRows.findIndex(row => row.id === object.id) === -1) {
          const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
          if (mapObjectIdx > -1) {
            this.mapObjects.splice(mapObjectIdx, 1)
            this.emitMapObjectsChanged()
          }
        }
      } else {
        this.changeShowOnMapProperty(object, true)
      }
    },
    changeShowOnMapProperty(object, watch) {
      if (object.user_object) {
        axios
          .patch(`/user-object/${object.user_object.id}/change-show-on-map`, {show_on_map: watch})
          .then(response => {
            const idx = this.objects.findIndex(item => item.id === object.id)
            if (idx > -1) {
              this.refreshObjectInfo(idx, response.data)
            }
          })
      } else {
        axios
          .post('/user-object', {object_id: object.id, show_on_map: true})
          .then(response => {
            const idx = this.objects.findIndex(item => item.id === object.id)
            if (idx > -1) {
              this.refreshObjectInfo(idx, response.data)
            }
          })
      }
    },
    emitPenToObject(mapObject) {
      this.$emit('pan-to-object', mapObject)
    },
    emitMapObjectsChanged() {
      this.$emit('map-objects-changed', this.mapObjects)
    },
    onMenuReportItemClick(data) {
      switch (data.report.type) {
        case 'common':
          this.$emit('open-common-report-window', data.object)
          break
      }
    },
    onSearch() {
      axios.get(`/object/user-objects?search=` + this.objectFilter)
        .then(response => {
          const data = response.data
          this.objects.map(object => {
            const idx = data.findIndex(item => item.id === object.id)
            object.visible = (
              !object.user_object || (
                object.user_object && (object.user_object.show_in_list || this.showAllHiddenObjects)
              )
            ) && idx > -1
          })
        })
        .catch(error => console.log(error))
    },
    onObjectTargetingClick(data) {
      if (data.on) {
        this.objectTargetingOn(data.object)
      } else {
        this.objectTargetingOff(data.object)
      }
    },
    objectTargetingOn(object) {
      if (object.equipments && object.equipments[0] && object.equipments[0].imei) {
        const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
        const mapObject = {...object.equipments[0].last_message, name: object.name, object_id: object.id}
        if (mapObjectIdx > -1) {
          this.emitPenToObject(mapObject)
        } else {
          this.mapObjects.push(mapObject)
          this.emitMapObjectsChanged()
          this.emitPenToObject(mapObject)
        }
      }
      this.changeTargetOnProperty(object, true)
    },
    objectTargetingOff(object) {
      if (!object.user_object.show_on_map && this.selectedRows.findIndex(row => row.id === object.id) === -1) {
        const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
        if (mapObjectIdx > -1) {
          this.mapObjects.splice(mapObjectIdx, 1)
          this.emitMapObjectsChanged()
        }
      }
      this.changeTargetOnProperty(object, false)
    },
    changeTargetOnProperty(object, value) {
      if (object.user_object) {
        axios
          .patch(`/user-object/${object.user_object.id}/change-target-on`, {target_on: value})
          .then(response => {
            const idx = this.objects.findIndex(item => item.id === object.id)
            if (idx > -1) {
              this.refreshObjectInfo(idx, response.data)
            }
          })
      } else {
        axios
          .post('/user-object', {object_id: object.id, target_on: true})
          .then(response => {
            const idx = this.objects.findIndex(item => item.id === object.id)
            if (idx > -1) {
              this.refreshObjectInfo(idx, response.data)
            }
          })
      }
    },
    onChangeSelectAll() {
      this.objects.map(object => object.checked = this.selectAll)
    },
    onShowAllHiddenObjectsClick() {
      this.showAllHiddenObjects = !this.showAllHiddenObjects
      this.objects.map(object => {
        if (object.user_object && !object.user_object.show_in_list) {
          object.visible = this.showAllHiddenObjects
        }
      })
    },
    onMultipleObjectsActionsContextMenuClick(item) {
      const objects = this.objects.filter(object => object.checked)
      if (!objects.length) {
        this.toastWarning('Не выбран ни один объект из списка')
        return false
      }

      let action = ''
      let params = {object_ids: objects.map(object => object.id).join(',')}
      switch (item.type) {
        case 'show-checked-objects-on-map':
          action = 'change-show-on-map'
          params.show_on_map = true
          break;
        case 'hide-checked-objects-on-map':
          action = 'change-show-on-map'
          params.show_on_map = false
          break;
        case 'show-checked-objects-on-list':
          action = 'change-visibility-in-list'
          params.show_in_list = true
          break;
        case 'hide-checked-objects-on-list':
          action = 'change-visibility-in-list'
          params.show_in_list = false
          break;
      }
      axios
        .post(`/user-object/many/${action}`, params)
        .then(response => {
          const data = response.data
          data.map(item => {
            const idx = this.objects.findIndex(object => object.id === item.id)
            if (idx > -1) {
              this.refreshObjectInfo(idx, item)
              if (action === 'change-show-on-map') {
                this.changeShowOnMapForSpecificObject(this.objects[idx])
              }
            }
          })
        })
    },
    onListSettingsContextMenuClick(item) {
      item.checked = !item.checked
      const settings = {}
      this.visibilitySettingsItems.map(setting => settings[setting.type] = setting.checked)
      const data = {settings: JSON.stringify(settings)}
      axios.post(`/user-object-list-settings/change`, data)
        .then(response => this.userObjectListSettings = response.data)
        .catch(error => console.log(error))
    },
    refreshObjectInfo(objectIdx, newData) {
      this.objects[objectIdx] = {...this.objects[objectIdx], ...newData}
      this.objects[objectIdx].visible = newData.user_object && (!newData.user_object.show_in_list && !this.showAllHiddenObjects)
        ? false : this.objects[objectIdx].visible
    },
    changeShowOnMapForSpecificObject(object) {
      const show = object.user_object.show_on_map
      if (show) {
        if (object.equipments && object.equipments[0] && object.equipments[0].imei) {
          const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
          const mapObject = {...object.equipments[0].last_message, name: object.name, object_id: object.id}
          if (mapObjectIdx > -1) {
            this.emitPenToObject(mapObject)
          } else {
            this.mapObjects.push(mapObject)
            this.emitMapObjectsChanged()
            this.emitPenToObject(mapObject)
          }
        }
      } else if (!object.user_object.target_on && this.selectedRows.findIndex(row => row.id === object.id) === -1) {
        const mapObjectIdx = this.mapObjects.findIndex(mapObject => mapObject.object_id === object.id)
        if (mapObjectIdx > -1) {
          this.mapObjects.splice(mapObjectIdx, 1)
          this.emitMapObjectsChanged()
        }
      }
    },
    loadUserName() {
      let user = localStorage.getItem('user')
      user = user ? JSON.parse(user) : null
      this.userName = user && user.name ? user.name : null
    }
  }
}
</script>

<style lang='scss' scoped>

.v-toolbar {
  .search-wrapper {
    .search-title {
      width: 88px;
    }
    .search-input {
      width: calc(100% - 197px);
    }
    .show-all-hidden-objects {
      &.active {
        background: #d8d8d8;
      }
    }
  }
  .v-btn {
    min-width: 20px;
  }
}

.table {
  .object-row {
    &.active-row, &:hover {
      background-color: var(--bs-table-hover-bg);
    }
    td {
      &:first-child {
        width: 10px !important;
      }
    }
  }
}

.separator {
  margin-right: 2px;
  margin-left: 2px;
}

.panel {
  cursor: pointer;
  height: 22px;
  padding: 0;
  img {
    border-radius: 3px;
    padding: 2px 3px 2px 3px;
  }
}

.v-list {
  margin-top: 0;
  margin-left: 8px;
}
</style>
