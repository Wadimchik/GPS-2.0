<template>
  <nav class="d-flex justify-content-center align-items-center mb-4">
    <table class="table table-bordered border-primary mb-0">
      <tbody>
      <tr>
        <td class="active"><router-link :to="{ name: 'accounts'}">Учетные записи</router-link></td>
        <td><router-link :to="{ name: 'objects'}">Объекты</router-link></td>
        <td><router-link :to="{ name: 'objectGroups'}">Группы объектов</router-link></td>
        <td><router-link :to="{ name: 'equipment'}">Оборудование</router-link></td>
        <td><router-link :to="{ name: 'users'}">Пользователи</router-link></td>
        <td><router-link :to="{ name: 'tariffs'}">Тарифы</router-link></td>
        <td><router-link :to="{ name: 'equipmentType'}">Типы оборудования</router-link></td>
        <td><router-link :to="{ name: 'repeater'}">Ретранслятор</router-link></td>
        <td><router-link :to="{ name: 'usersRoles'}">Роли пользователей</router-link></td>
        <td><router-link :to="{ name: 'events'}">Панель событий</router-link></td>
        <td><router-link :to="{ name: 'dealers'}">Дилеры</router-link></td>
        <td><router-link :to="{ name: 'basket'}">Корзина</router-link></td>
        <td><router-link :to="{ name: 'support'}">Техподдержка</router-link></td>
      </tr>
      </tbody>
    </table>
    <v-btn
      class="ml-4"
      @click="logout"
    >Выйти</v-btn>
  </nav>
</template>
<script>
import authManager from '@/js/composables/auth-manager'

export default {
  setup() {
    const { logout } = authManager()
    return {
      logout
    }
  }
}
</script>
