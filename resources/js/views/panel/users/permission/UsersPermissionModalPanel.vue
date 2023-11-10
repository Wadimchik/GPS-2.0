<template>
  <div
    class="content-panel h-100 mr-4 w-25"
    ref="panel"
  >
    <v-card class="h-100">
      <v-toolbar theme="gray">
        <v-toolbar-title class="text-sm-">Добавить элемент</v-toolbar-title>
      </v-toolbar>
      <v-card-text class="p-0">
        <v-tabs
          v-model="activeTab"
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

        <v-window v-model="activeTab">
          <v-window-item
            v-for="item in tabs"
            :key="item.key"
            :value="item"
          >
            <v-card flat>
              <v-card-text class="p-0">
                <template v-if="item.key === 'accounts'">
                  <users-permission-modal-account-tab
                    @row-double-click="onAccountTabDbClick"
                  ></users-permission-modal-account-tab>
                </template>
                <template v-else>
                  <users-permission-modal-object-tab
                    @row-double-click="onObjectTabDbClick"
                  ></users-permission-modal-object-tab>
                </template>
              </v-card-text>
            </v-card>
          </v-window-item>
        </v-window>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>

import {ref} from 'vue'
import UsersPermissionModalAccountTab from '@/js/views/panel/users/permission/UsersPermissionModalAccountTab.vue'
import UsersPermissionModalObjectTab from '@/js/views/panel/users/permission/UsersPermissionModalObjectTab.vue'

export default {
  name: 'UsersPermissionModalPanel',
  components: {
    UsersPermissionModalObjectTab,
    UsersPermissionModalAccountTab
  },
  emits: ['select-account', 'select-object'],
  props: {
  },
  setup(props, { emit }) {
    const activeTab = ref(null)
    const tabs = [
      {
        key: 'accounts',
        label: 'Аккаунты'
      },
      {
        key: 'objects',
        label: 'Объекты'
      }
    ]

    const onObjectTabDbClick = object => emit('select-object', object)
    const onAccountTabDbClick = account => emit('select-account', account)

    return {
      activeTab,
      tabs,

      onObjectTabDbClick,
      onAccountTabDbClick
    }
  }
}

</script>
<style lang='scss' scoped>
.v-toolbar {
  .search-wrapper {
    .search-title {
      width: 40px;
    }
  }
}
</style>
