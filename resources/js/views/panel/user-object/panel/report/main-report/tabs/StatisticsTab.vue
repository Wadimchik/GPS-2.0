<template>
  <v-table
    density="compact"
    class="table statistics"
    hover
  >
    <tbody>
    <tr>
      <td>Объект</td>
      <td>{{ objectName }}</td>
    </tr>
    <template v-if="statistics">
      <tr v-for="rowKey in Object.keys(statistics)">
        <td>{{ statistics[rowKey].label }}</td>
        <td>
          {{
            statistics[rowKey].value
              ? (
                statistics[rowKey].value.toString() + (
                  statistics[rowKey].prefix ? ' ' + statistics[rowKey].prefix.toString() : ''
                )
              )
              : '-'
          }}
        </td>
      </tr>
    </template>
    </tbody>
  </v-table>
</template>

<script>
export default {
  name: 'StatisticsTab',
  props: {
    objectName: String,
    statistics: Object
  }
}
</script>

<style lang='scss' scoped>
.table.statistics {
  font: normal 11px/13px tahoma, arial, verdana, sans-serif;
  tr {
    &:nth-child(even) {
      background-color: var(--bs-table-hover-bg);
    }
    td {
      height: 13px;
      padding: 3px 6px 4px 6px;
    }
  }
}
</style>
