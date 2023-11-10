<template>
  <div class="d-flex w-100">
    <div class="toolbar">
      <div
        class="panel d-flex align-items-center justify-content-center"
        @click="onClickPlayBtn"
      >
        <img
          :src="playerIcon"
          :title="playerIconTitle"
        >
      </div>
      <div
        class="panel d-flex align-items-center justify-content-center"
      >
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
              title="Скорость проигрывания движения объекта по маршруту"
            >
              <span class="pl-1 pr-1">{{ activeItem.text }}</span>
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
                @click="onContextMenuClick(index)"
              >
                <template #prepend="{ isActive }">
                  <div class="dot-wrapper d-flex align-center">
                    <div
                      class="dot"
                      :class="{'active': item.active}"
                    ></div>
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
    <v-table
      ref="messagesTable"
      density="compact"
      class="table messages"
      fixed-header
      hover
      height="340px"
    >
      <thead>
      <tr>
        <th class="text-left">№</th>
        <th class="text-left">Время</th>
        <th class="text-left">Направление</th>
        <th class="text-left">Координаты</th>
        <th class="text-left">Скорость</th>
        <th class="text-left">Положение</th>
        <th class="text-left">Данные</th>
      </tr>
      </thead>
      <tbody>
      <template v-if="messages">
        <tr
          v-for="(message, index) in messages"
          :class="{'active-row': activeMessage && activeMessage.id === message.id}"
          @click="onCoordsClick(message)"
        >
          <td>{{ index + 1 }}</td>
          <td>{{ message.time }}</td>
          <td>{{ message.course }}</td>
          <td>{{ message.coords }}</td>
          <td>{{ message.speed }} км/ч</td>
          <td>-</td>
          <td>-</td>
        </tr>
      </template>
      </tbody>
    </v-table>
  </div>
</template>

<script>
import {computed, ref} from 'vue'

export default {
  name: 'MessagesTab',
  emits: ['select-row', 'unselect-row'],
  props: {
    messages: Array
  },
  setup(props, { emit }) {

    const messagesTable = ref()
    const items = ref([
      {
        text: '1x',
        type: 1,
        active: true,
      },
      {
        text: '2x',
        type: 2,
        active: false,
      },
      {
        text: '3x',
        type: 3,
        active: false,
      },
      {
        text: '4x',
        type: 4,
        active: false,
      },
      {
        text: '5x',
        type: 5,
        active: false,
      },
    ])
    const step = 21
    const activeMessage = ref(null)
    let intervalTime = 200
    let interval = ref(null)

    const activeItem = computed(() => items.value.find(item => item.active))
    const playerIcon = computed(() => {
      return interval.value
        ? new URL('@/img/common/pause.png', import.meta.url).href
        : new URL('@/img/common/play.png', import.meta.url).href
    })
    const playerIconTitle = computed(() => {
      return `${interval.value ? 'Остановить' : 'Запустить'} проигрывание маршрута движения объекта`
    })

    const onCoordsClick = message => {
      if (activeMessage.value && message.id === activeMessage.value.id) {
        activeMessage.value = null
        emitUnselectRow()
      } else {
        activeMessage.value = message
        emitSelectRow()
      }
    }

    const emitSelectRow = () => emit(
      'select-row',
      {id: activeMessage.value.id, lat: activeMessage.value.lat, lon: activeMessage.value.lon}
    )

    const emitUnselectRow = () => emit('unselect-row')

    const startMessagePlayer = () => {
      const time = intervalTime / activeItem.value.type
      let messageIndex = activeMessage.value
        ? props.messages.findIndex(message => message.id === activeMessage.value.id)
        : 0
      const messagesCount = props.messages.length
      const $tableWrapper = messagesTable.value.$el.getElementsByClassName('v-table__wrapper')[0]
      activeMessage.value = props.messages[messageIndex]
      interval.value = setInterval(() => {
        if (messageIndex + 1 < messagesCount) {
          $tableWrapper.scrollBy(0, step)
          messageIndex += 1
        } else {
          $tableWrapper.scrollTo(0, 0)
          messageIndex = 0
        }
        activeMessage.value = props.messages[messageIndex]
        emitSelectRow()
      }, time)
    }

    const onContextMenuClick = selectedIndex => {
      items.value.map((item, idx) => item.active = idx === selectedIndex)
      if (interval.value) {
        stopMessagePlayer()
        startMessagePlayer()
      }
    }

    const onClickPlayBtn = () => {
      if (interval.value) {
        stopMessagePlayer()
      } else {
        startMessagePlayer()
      }
    }

    const stopMessagePlayer = () => {
      if (interval.value) {
        clearInterval(interval.value)
        interval.value = null
      }
    }

    return {
      activeMessage,
      messagesTable,
      activeItem,
      items,
      playerIcon,
      playerIconTitle,


      onCoordsClick,
      emitSelectRow,
      emitUnselectRow,
      startMessagePlayer,
      stopMessagePlayer,
      onClickPlayBtn,
      onContextMenuClick
    }
  }
}
</script>

<style lang='scss' scoped>

.toolbar {
  width: 46px;
  font-size: 11px;
  padding: 3px;
  border-color: #bcb0b0;
  background-color: #d8d8d8;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e6e6e6), color-stop(100%, #efefef));
  background-image: -moz-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: -o-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: linear-gradient(to top, #e6e6e6, #efefef);
  .panel {
    height: 22px;
    &:not(:first-child) {
      margin-top: 2px;
    }
  }
}

.table.messages {
  font: normal 11px/13px tahoma, arial, verdana, sans-serif;
  tr {
    &:nth-child(even):not(.active-row) {
      background-color: var(--bs-table-hover-bg);
    }
    td {
      cursor: pointer;
      height: 13px;
      padding: 3px 6px 4px 6px;
    }
  }
}
</style>
