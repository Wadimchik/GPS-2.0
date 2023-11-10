<template>
  <td class="pr-0">
    <input
      class="form-check-input cursor-pointer"
      type="checkbox"
      v-model="object.checked"
      @click.stop
    >
  </td>
  <td
    v-if="showGlobeIconCell"
    class="pr-0"
    @click.stop="onGlobeClick(object)"
  >
    <img
      :src="globeIcon"
      :title="globeIconTitle"
    >
  </td>
  <td
    v-if="showObjectNameCell"
    class="name"
    :class="{'hidden': object.user_object && !object.user_object.show_in_list}"
  >{{ object.name }}</td>
  <td
    v-if="showObjectStatusesCell"
    class="d-flex align-items-center justify-content-end"
  >
    <img
      v-if="showCarActiveStatusIconCell"
      :src="carActiveStatusIcon"
      :title="carActiveStatusIconTitle"
      class="mr-1"
    >
    <img
      v-if="showSathStatusIconCell"
      :src="sathStatusIcon"
      :title="sathStatusIconTitle"
    >
    <img
      v-if="showTargetingIconCell"
      :src="targetingIcon"
      :title="targetingIconTitle"
      class="ml-1 cursor-pointer"
      @click.stop="objectTargetingClick(object)"
    >
    <img
      v-if="showCommandsIconCell"
      class="ml-1 cursor-pointer"
      src="@/img/common/commands.png"
    >
    <v-menu
      v-if="showReportsIconCell"
      anchor="bottom end"
      rounded
      class="context-menu"
      close-on-back
      close-on-content-click
    >
      <template #activator="{ props }">
        <img
          v-bind="props"
          src="@/img/report.png"
          title="Отчеты для данного объекта"
          class="ml-2"
          @click.stop
        >
      </template>
      <v-list class="context-menu-list p-0">
        <div class="context-menu-separator h-100"></div>
        <div class="pt-1 pb-1">
          <v-list-item
            v-for="(reportItem, index) in reportItems"
            :key="index"
            class="d-flex align-items-center cursor-pointer"
            @click="onMenuReportItemClick(index, object, reportItem)"
          >
            <template #prepend="{ isActive }">
              <div class="icon-wrapper">
                <img src="@/img/context-menu/coldiag.png">
              </div>
            </template>
            <template #default="{ isActive }">
              <v-list-item-title :title="reportItem.title">{{ reportItem.text }}</v-list-item-title>
            </template>
          </v-list-item>
        </div>
      </v-list>
    </v-menu>
    <img
      class="ml-1 cursor-pointer"
      v-if="showSettingsIconCell"
      src="@/img/common/settings.png"
    >
  </td>
</template>

<script>

export default {
  name: 'ObjectListTabItem',
  emits: ['globe-click', 'object-targeting-click', 'menu-report-click'],
  props: {
    object: Object,
    listSettings: Object
  },
  data() {
    return {
      reportItems: [
        {text: 'Общий отчёт', title: 'Новый общий отчет', type: 'common'},
        {text: 'Отчёт по топливу', title: 'Новый отчет по данным топливных датчиков', type: 'fuel-sensor'},
        {text: 'Отчёт с группировкой', title: 'Новый отчет с группировкой по дням', type: 'by-days'},
        {text: 'Отчёт по адресам(ГУИС)', title: 'Новый отчет по посещенным адресам', type: 'visited-addresses'},
      ],
    }
  },
  computed: {
    globeIcon() {
      return this.object && this.object.user_object && this.object.user_object.show_on_map
        ? new URL('@/img/objects/globe-active.png', import.meta.url).href
        : new URL('@/img/objects/globe-inactive.png', import.meta.url).href
    },
    globeIconTitle() {
      return this.object && this.object.user_object && this.object.user_object.show_on_map
        ? 'Прекратить отображение объекта на карте' : 'Отобразить объект на карте'
    },
    carActiveStatusIcon() {
      return this.object.equipments && this.object.equipments.length && this.object.equipments[0].last_message
        && this.object.equipments[0].last_message.is_moving
          ? new URL('@/img/objects/car-active.png', import.meta.url).href
          : new URL('@/img/objects/car-stop.png', import.meta.url).href
    },
    carActiveStatusIconTitle() {
      return this.object.equipments && this.object.equipments.length && this.object.equipments[0].last_message
        && this.object.equipments[0].last_message.is_moving
          ? 'Последнее состояние: автомобиль едет' : 'Последнее состояние: автомобиль стоит'
    },
    sathStatusIcon() {
      let icon = new URL('@/img/objects/sath-red.png', import.meta.url).href
      if (
        this.object.equipments && this.object.equipments.length && this.object.equipments[0].last_message
          && this.object.equipments[0].last_message.time_diff < 300
      ) {
        icon = new URL('@/img/objects/sath-yellow.png', import.meta.url).href
      } else if (
        this.object.equipments && this.object.equipments.length && this.object.equipments[0].last_message
          && this.object.equipments[0].last_message.time_diff < 3600
      ) {
        icon = new URL('@/img/objects/sath-green.png', import.meta.url).href
      }
      return icon
    },
    sathStatusIconTitle() {
      let title = `Последнее сообщение: нет данных\nКоличество спутников: нет данных`
      if (this.object.equipments && this.object.equipments.length && this.object.equipments[0].last_message) {
        let time = this.$moment.unix(
            this.object.equipments[0].last_message.time_utc_timestamp
        ).format('YYYY-MM-DD HH:mm:ss')
        title = `Последнее сообщение: ${time}\nКоличество спутников: ${this.object.equipments[0].last_message.sats}`
      }
      return title
    },
    targetingIcon() {
      return this.object && this.object.user_object && this.object.user_object.target_on
          ? new URL('@/img/objects/target-on.png', import.meta.url).href
          : new URL('@/img/objects/target-off.png', import.meta.url).href
    },
    targetingIconTitle() {
      return this.object && this.object.user_object && this.object.user_object.target_on
          ? 'Прекратить отслежвание объекта' : 'Отслеживать объект'
    },
    showGlobeIconCell() {
      return this.listSettings ? this.listSettings.show_on_map_action_is_visible : true
    },
    showObjectNameCell() {
      return this.listSettings ? this.listSettings.object_name_is_visible : true
    },
    showCarActiveStatusIconCell() {
      return this.listSettings ? this.listSettings.object_state_info_is_visible : true
    },
    showSathStatusIconCell() {
      return this.listSettings ? this.listSettings.last_message_info_is_visible : true
    },
    showTargetingIconCell() {
      return this.listSettings ? this.listSettings.target_on_action_is_visible : true
    },
    showReportsIconCell() {
      return this.listSettings ? this.listSettings.reports_is_visible : true
    },
    showCommandsIconCell() {
      return this.listSettings ? this.listSettings.objects_managing_is_visible : true
    },
    showSettingsIconCell() {
      return this.listSettings ? this.listSettings.objects_settings_is_visible : true
    },
    showObjectStatusesCell() {
      return this.showCarActiveStatusIconCell || this.showSathStatusIconCell || this.showTargetingIconCell
        || this.showReportsIconCell || this.showCommandsIconCell || this.showSettingsIconCell
    }
  },
  methods: {
    onGlobeClick(object) {
      this.$emit('globe-click', object)
    },
    objectTargetingClick(object) {
      this.emitObjectTargetingClick(object, !(object.user_object && object.user_object.target_on))
    },
    emitObjectTargetingClick(object, on) {
      this.$emit('object-targeting-click', {object, on})
    },
    onMenuReportItemClick(index, object, report) {
      this.$emit('menu-report-click', {index, object, report})
    },
  }
}
</script>

<style lang='scss' scoped>
.name {
  &.hidden {
    opacity: 0.5;
  }
}
</style>
