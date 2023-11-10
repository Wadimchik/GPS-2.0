<template>
  <v-toolbar height="26" class="pt-1 pb-1 pr-2 d-flex">
    <div class="search-wrapper">
      <strong class="search-title">Искать:</strong>
      <input
        type="text"
        class="search-input"
        v-model="objectFilter"
        @keyup="fetchAccounts"
      >
    </div>
  </v-toolbar>
  <v-table density="compact" class="table">
    <thead>
      <tr>
        <th class="text-left">Название</th>
      </tr>
    </thead>
    <tbody>
      <template
        v-if="accounts.length"
        v-for="account in accounts"
        :key="account.id"
      >
        <tr
          class="cursor-pointer"
          @dblclick="onDblClick(account)"
        >
          <td class="name">{{ account.name }}</td>
        </tr>
      </template>
      <template v-else>
        <tr>
          <td class="text-center">
            <strong>Список пуст</strong>
          </td>
        </tr>
      </template>
    </tbody>
  </v-table>
</template>

<script>
import {inject, onMounted, ref, watch} from 'vue'
import axios from 'axios'

export default {
  name: 'UsersPermissionModalAccountTab',
  emits: ['row-double-click'],
  setup(props, { emit }) {
    const accounts = ref([])
    const initialAccounts = ref([])
    const userPermissions = inject('user-permissions')
    const objectFilter = ref(null)

    onMounted(() => fetchAccounts())

    watch(userPermissions.value, () => checkAccounts())

    const checkAccounts = () => {
      const selectedAccounts = []
      initialAccounts.value.map(item => {
        if (userPermissions.value) {
          if (!userPermissions.value.find(p => p.entity_type === 'account' && p.id === item.id)) {
            selectedAccounts.push(item)
          }
        }
      })
      accounts.value = selectedAccounts
    }
    const fetchAccounts = () => {
      let url = 'account/get-for-dropdown' + (objectFilter.value ? `?search=${objectFilter.value}` : '')
      axios.get(url)
        .then(response => {
          initialAccounts.value = response.data
          if (userPermissions.value) {
            checkAccounts()
          } else {
            accounts.value = response.data
          }
        })
    }
    const onDblClick = account => emit('row-double-click', account)

    return {
      accounts,
      objectFilter,

      onDblClick,
      fetchAccounts
    }
  }
}

</script>
