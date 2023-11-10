<template>
  <v-toolbar height="26" class="pt-1 pb-1 pr-2 d-flex">
    <div class="search-wrapper">
      <strong class="search-title">Искать:</strong>
      <input
        type="text"
        class="search-input"
        v-model="objectFilter"
        @keyup="fetchObjects"
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
        v-if="objects.length"
        v-for="object in objects"
        :key="object.id"
      >
        <tr
          class="cursor-pointer"
          @dblclick="onDblClick(object)"
        >
          <td class="name">{{ object.name }}</td>
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
  name: 'UsersPermissionModalObjectTab',
  emits: ['row-double-click'],
  setup(props, { emit }) {
    const objects = ref([])
    const initialObjects = ref([])
    const userPermissions = inject('user-permissions')
    const objectFilter = ref(null)

    onMounted(() => fetchObjects())

    watch(userPermissions.value, () => checkObjects())

    const checkObjects = () => {
      const selectedObjects = []
      initialObjects.value.map(item => {
        if (userPermissions.value) {
          if (!userPermissions.value.find(p => p.entity_type === 'object' && p.id === item.id)) {
            selectedObjects.push(item)
          }
        }
      })
      objects.value = selectedObjects
    }
    const fetchObjects = () => {
      const url = 'object/get-for-dropdown' + (objectFilter.value ? `?search=${objectFilter.value}` : '')
      axios.get(url)
        .then(response => {
          initialObjects.value = response.data
          if (userPermissions.value) {
            checkObjects()
          } else {
            objects.value = response.data
          }
        })
    }
    const onDblClick = object => emit('row-double-click', object)

    return {
      objects,
      objectFilter,

      onDblClick,
      fetchObjects
    }
  }
}

</script>
