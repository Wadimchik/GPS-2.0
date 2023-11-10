<template>
  <v-table class="table mt-5 main-table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Имя</th>
    </tr>
    </thead>
    <tbody>
    <tr
      v-for="(item, idx) in data"
      class="cursor-pointer"
      :class="[
        {'table-danger': item.block},
        {'active-row': idx === active_element}
      ]"
      @click="processClick(idx)"
      @dblclick="this.$emit('row-double-click', idx)"
    >
      <th scope="row">{{ item.id }}</th>
      <td>{{ item.name }}</td>
    </tr>
    </tbody>
  </v-table>
</template>
<script>
export default {
  name: 'TariffsTable',
  emits: ['row-click', 'row-double-click'],
  data() {
    return {
      active_element: null
    }
  },
  props: {
    data: Array
  },
  methods: {
    processClick(idx) {
      this.active_element = idx !== this.active_element ? idx : null
      this.$emit('row-click', this.active_element)
    }
  },
}
</script>
