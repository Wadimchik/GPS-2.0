<template>
  <v-dialog
    v-model="showDialog"
    fullscreen
    persistent
    no-click-animation
  >
    <v-card>
      <v-toolbar
        dark
        color="gray"
      >
        <v-toolbar-title>{{ title }}</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <v-row class="w-100 m-0 h-100">
          <v-col
            class="p-0 d-flex align-items-center"
            cols="12"
          >
            <users-permission-modal-panel
              @select-account="onSelectAccount"
              @select-object="onSelectObject"
            ></users-permission-modal-panel>

            <v-data-table
              items-per-page="-1"
              :headers="headers"
              :items="items"
              class="elevation-1 w-100 h-100"
            >
              <template #item.entity_type="{ item }">
                <div>{{ item.raw.entity_type }}</div>
              </template>
              <template #item.view="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.view"
                  >
                </div>
              </template>
              <template #item.view_sleeping="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.view_sleeping"
                  >
                </div>
              </template>
              <template #item.blocking="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.blocking"
                  >
                </div>
              </template>
              <template #item.coordinate="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.coordinate"
                  >
                </div>
              </template>
              <template #item.reboot="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.reboot"
                  >
                </div>
              </template>
              <template #item.property_view="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.property_view"
                  >
                </div>
              </template>
              <template #item.property_change="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.property_change"
                  >
                </div>
              </template>
              <template #item.fuel="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.fuel"
                  >
                </div>
              </template>
              <template #item.sensor="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <input
                    class="cursor-pointer"
                    type="checkbox"
                    v-model="item.raw.sensor"
                  >
                </div>
              </template>
              <template #item.actions="{ item }">
                <div class="d-flex align-items-center justify-content-center">
                  <v-icon
                    size="small"
                    @click.stop="onClickRemoveItem(item.raw)"
                  >mdi-delete</v-icon>
                </div>
              </template>
              <template #no-data>
                <tr>
                  <td colspan="12" class="text-center w-100">
                    <strong>Нет данных</strong>
                  </td>
                </tr>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions class="mb-4">
        <v-spacer></v-spacer>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="save"
        >Сохранить</v-btn>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="showDialog = false"
        >Отменить</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>

import {computed, onMounted, provide, ref, watch} from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import UsersPermissionModalPanel from '@/js/views/panel/users/permission/UsersPermissionModalPanel.vue'
import appToast from "@/js/composables/toast-notification";

export default {
  name: 'UsersPermissionModal',
  components: {
    UsersPermissionModalPanel, VDataTable
  },
  props: {
    user: Object,
    visible: Boolean
  },
  emits: ['hide'],
  setup(props, { emit }) {
    const showDialog = ref(false)
    const title = computed(() => props.user ? `Права пользователя "${props.user.name}"` : null)
    const items = ref([])
    const headers = [
      {
        title: 'Тип', key: 'entity_type',
      },
      {
        title: 'Имя', key: 'name',
      },
      {
        title: 'Просмотр', key: 'view',
      },
      {
        title: 'Просмотр "спящих"', key: 'view_sleeping'
      },
      {
        title: 'Блокировка', key: 'blocking'
      },
      {
        title: 'Координаты', key: 'coordinate'
      },
      {
        title: 'Перезагрузка', key: 'reboot'
      },
      {
        title: 'Просмотр свойств', key: 'property_view'
      },
      {
        title: 'Изменение свойств', key: 'property_change'
      },
      {
        title: 'Топливо', key: 'fuel'
      },
      {
        title: 'Датчики', key: 'sensor'
      },
      {
        title: 'Действия', key: 'actions'
      },
    ]
    const permissions = {
      view: false,
      view_sleeping: false,
      blocking: false,
      coordinate: false,
      reboot: false,
      property_view: false,
      property_change: false,
      fuel: false,
      sensor: false,
    }
    const { toastSuccess, toastError } = appToast()

    provide('user-permissions', items)

    watch(() => props.visible, value => {
      showDialog.value = value
      if (value) {
        fetchPermissions()
      }
    })
    watch(showDialog, () => {
      if (!showDialog.value) {
        items.value = []
        emit('hide')
      }
    })

    const onSelectAccount = account => {
      const idx = items.value.findIndex(item => item.entity_type === 'account' && item.id === account.id)
      if (idx === -1) {
        items.value.push({entity_type: 'account', ...account, ...permissions})
      }
    }
    const onSelectObject = object => {
      const idx = items.value.findIndex(item => item.entity_type === 'object' && item.id === object.id)
      if (idx === -1) {
        items.value.push({entity_type: 'object', ...object, ...permissions})
      }
    }
    const save = () => {
      axios.post('user-permission', {permissions: items.value, user_id: props.user.id})
        .then(response => {
          if (response.data && response.data.result) {
            toastSuccess('Права успешно сохранены')
          } else {
            toastError('Не удалось сохранить права')
          }
        })
        .catch(() => toastError('Не удалось сохранить права'))
    }
    const fetchPermissions = () => {
      axios.get(`user-permission/${props.user.id}`).then(response => {
        response.data.map(item => {
          const p = {...permissions}
          item.permissions.map(permission => {
            if (p.hasOwnProperty(permission)) {
              p[permission] = true
            }
          })
          items.value.push({entity_type: item.entity_type, id: item.id, name: item.name, ...p})
        })
      })
    }
    const onClickRemoveItem = row => {
      const idx = items.value.findIndex(item => row.entity_type === item.entity_type && row.id === item.id)
      if (idx > -1) {
        items.value.splice(idx, 1)
      }
    }

    return {
      showDialog,
      title,
      headers,
      items,

      onSelectAccount,
      onSelectObject,
      save,
      onClickRemoveItem
    }
  }
}

</script>

<style lang='scss' scoped>
.v-data-table__tr {
  .v-data-table__td {
    input[type='checkbox'], i {
      margin-left: -26px;
    }
  }
}
</style>
