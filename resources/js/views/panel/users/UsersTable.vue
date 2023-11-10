<template>
  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Тип пользователя</th>
        <th scope="col">Основная учётная запись</th>
        <th scope="col">Статус</th>
        <th scope="col">Войти</th>
        <th
          scope="col"
          class="text-center"
        >Права</th>
        <th scope="col">Последний вход</th>
        <th scope="col">Последнее действие</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(item, idx) in users"
        class="cursor-pointer"
        @click="processClick(idx)"
        :class="[
          { 'table-danger': item.block || !item.account },
          { 'active-row': idx === activeElement },
        ]"
        @dblclick="$emit('row-double-click', item)"
      >
        <th scope="row">{{ item.id }}</th>
        <td>{{ item.name }}</td>
        <td>{{ additionalInfo.roles[item.role].name }}</td>
        <td>{{ returnValueOrNull(additionalInfo.accounts, item.account) }}</td>
        <td>{{ blockTextReturn(item.block) }}</td>
        <td><a href="#">Войти как пользователь</a></td>
        <td class="align-middle">
          <div
            class="d-flex justify-content-center"
            title="Редактировать права"
            @click.stop="editPermissions(item)"
          >
            <img src="@/img/common/permissions.png">
          </div>
        </td>
        <td>{{ item.last_login.replace('-', '.') }}</td>
        <td>{{ item.last_action.replace('-', '.') }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import {ref} from 'vue'

export default {
  name: 'UsersTable',
  emits: ['row-click', 'row-double-click', 'permissions-click'],
  props: {
    users: Array,
    additionalInfo: Object,
  },
  setup(props, { emit }) {
    const activeElement = ref(null)
    const editPermissions = account => emit('permissions-click', account)
    const blockTextReturn = block => block ? 'Заблокирован' : 'Активен'
    const processClick = idx => {
      activeElement.value = idx !== activeElement.value ? idx : null
      emit('row-click', activeElement.value)
    }
    const returnValueOrNull = (data, item) => data[item] ? data[item].name : null

    return {
      activeElement,

      editPermissions,
      blockTextReturn,
      processClick,
      returnValueOrNull
    }
  },
}
</script>
