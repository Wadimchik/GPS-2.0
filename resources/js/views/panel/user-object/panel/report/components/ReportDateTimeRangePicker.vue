<template>

  <div class="w-100 d-flex align-items-center justify-content-center period-filter mt-4">
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('today')"
    >Сегодня</span>
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('yesterday')"
    >Вчера</span>
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('this-week')"
    >Эта неделя</span>
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('prev-week')"
    >Прошлая неделя</span>
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('this-month')"
    >Этот месяц</span>
    <span
      class="period-filter-item"
      @click="onClickCustomPeriod('prev-month')"
    >Прошлый месяц</span>
  </div>

  <div class="d-flex align-items-center mt-4 w-100">
    <div class="d-flex align-center flex-column w-100">
      <div class="item d-flex w-100">
        <div class="d-flex align-items-center w-100 mr-2">
          <label
            for="date-from"
            class="mr-2"
          >С:</label>
          <datepicker
            id="date-from"
            v-model="dateFrom"
            locale="ru"
            cancel-text="Отменить"
            select-text="Выбрать"
            format="dd.MM.yyyy"
            date-picker
            auto-apply
            :enable-time-picker="false"
            @update:model-value="onChangeDateFrom"
          ></datepicker>
        </div>

        <div class="d-flex align-items-center w-100">
          <label
            for="time-from"
            class="mr-2"
          >Время:</label>
          <datepicker
            id="time-from"
            v-model="timeFrom"
            locale="ru"
            cancel-text="Отменить"
            select-text="Выбрать"
            format="HH:mm"
            time-picker
            @update:model-value="onChangeTimeFrom"
          ></datepicker>
        </div>
      </div>

      <div class="item d-flex w-100 mt-4">
        <div class="d-flex align-items-center w-100 mr-2">
          <label
            for="date-to"
            class="mr-2"
          >По:</label>
          <datepicker
            id="date-to"
            v-model="dateTo"
            locale="ru"
            cancel-text="Отменить"
            select-text="Выбрать"
            format="dd.MM.yyyy"
            date-picker
            auto-apply
            :enable-time-picker="false"
            @update:model-value="onChangeDateTo"
          ></datepicker>
        </div>

        <div class="d-flex align-items-center w-100">
          <label
            for="time-to"
            class="mr-2"
          >Время:</label>
          <datepicker
            id="time-to"
            v-model="timeTo"
            locale="ru"
            cancel-text="Отменить"
            select-text="Выбрать"
            time-picker
            @update:model-value="onChangeTimeTo"
          ></datepicker>
        </div>
      </div>

    </div>
  </div>

</template>

<script>
import {ref, onMounted} from 'vue'
import moment from 'moment'

export default {
  name: 'ReportDateTimeRangePicker',
  emits: ['period-changed'],
  setup(props, {emit}) {
    let dateFrom = ref(moment())
    let dateTo = ref(moment())
    let timeFrom = ref({hours: 0, minutes: 0, seconds: 0})
    let timeTo = ref({
      hours: dateTo.value.hours(), minutes: dateTo.value.minutes(), seconds: dateTo.value.seconds()
    })

    dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})

    onMounted(() => emitPeriodChanged())

    const onClickCustomPeriod = type => {
      switch (type) {
        case 'today':
          dateFrom.value = moment()
          dateTo.value = moment()
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: dateTo.value.hours(), minutes: dateTo.value.minutes(), seconds: dateTo.value.seconds()}
          break;
        case 'yesterday':
          dateFrom.value = moment().subtract(1, 'days')
          dateTo.value = moment().subtract(1, 'days')
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          dateTo.value.set({hour: 23, minute: 59, second: 59, millisecond: 59})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: 23, minutes: 59, seconds: 59}
          break;
        case 'this-week':
          dateFrom.value = moment().startOf('isoWeek')
          dateTo.value = moment()
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: dateTo.value.hours(), minutes: dateTo.value.minutes(), seconds: dateTo.value.seconds()}
          break;
        case 'prev-week':
          dateFrom.value = moment().subtract(1, 'weeks').startOf('isoWeek')
          dateTo.value = moment().subtract(1, 'weeks').endOf('isoWeek')
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          dateTo.value.set({hour: 23, minute: 59, second: 59, millisecond: 59})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: 23, minutes: 59, seconds: 59}
          break;
        case 'this-month':
          dateFrom.value = moment().startOf('month')
          dateTo.value = moment()
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: dateTo.value.hours(), minutes: dateTo.value.minutes(), seconds: dateTo.value.seconds()}
          break;
        case 'prev-month':
          dateFrom.value = moment().subtract(1, 'months').startOf('month')
          dateTo.value = moment().subtract(1, 'months').endOf('month')
          dateFrom.value.set({hour: 0, minute: 0, second: 0, millisecond: 0})
          dateTo.value.set({hour: 23, minute: 59, second: 59, millisecond: 59})
          timeFrom.value = {hours: 0, minutes: 0, seconds: 0}
          timeTo.value = {hours: 23, minutes: 59, seconds: 59}
          break;
      }
      emitPeriodChanged()
    }

    const onChangeDateFrom = () => {
      dateFrom.value = moment(dateFrom.value)
      emitPeriodChanged()
    }

    const onChangeTimeFrom = () => {
      let hours = 0
      let minutes = 0
      let seconds = 0
      if (timeFrom.value) {
        hours = timeFrom.value.hours
        minutes = timeFrom.value.minutes
        seconds = timeFrom.value.seconds
      }
      dateFrom.value.set({hour: hours, minute: minutes, second: seconds, millisecond: 0})
      emitPeriodChanged()
    }

    const onChangeDateTo = () => {
      dateTo.value = moment(dateTo.value)
      emitPeriodChanged()
    }

    const onChangeTimeTo = () => {
      let hours = 0
      let minutes = 0
      let seconds = 0
      if (timeTo.value) {
        hours = timeTo.value.hours
        minutes = timeTo.value.minutes
        seconds = timeTo.value.seconds
      }
      dateTo.value.set({hour: hours, minute: minutes, second: seconds, millisecond: 0})
      emitPeriodChanged()
    }

    const emitPeriodChanged = () => {
      emit(
        'period-changed',
        {
          from: timeFrom.value ? dateFrom.value : null,
          to: timeTo.value ? dateTo.value : null
        }
      )
    }

    return {
      dateFrom,
      timeFrom,
      dateTo,
      timeTo,
      onClickCustomPeriod,
      onChangeDateFrom,
      onChangeTimeFrom,
      onChangeDateTo,
      onChangeTimeTo
    }
  },
}
</script>

<style lang='scss' scoped>
.period-filter {
  .period-filter-item {
    font-weight: normal;
    font-family: tahoma, arial, verdana, sans-serif;
    font-size: 11px;
    cursor: pointer;
    text-decoration: underline;
    &:not(:first-child) {
      margin-left: 4px;
    }
    &:not(:last-child) {
      margin-right: 4px;
    }
  }
}
</style>
