<template>
  <div class="d-flex w-100">
    <div class="toolbar">
      <div
        class="panel d-flex align-items-center justify-content-center"
        @click="resetChartZoom"
      >
        <img
          src="@/img/common/zoom-out.png"
          title="Вернуться к первоначальному масштабу графика"
        >
      </div>
      <div
        class="panel d-flex align-items-center justify-content-center"
        @click="saveChartToPng"
      >
        <img
          src="@/img/common/printer.png"
          title="Сохранить график"
        >
      </div>
    </div>
    <div class="chart-container">
      <Line
        ref="lineChart"
        :data="chartData"
        :options="chartOptions"
      />
    </div>
  </div>
</template>

<script>
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, Filler
} from 'chart.js'
import zoomPlugin from 'chartjs-plugin-zoom';
import {ref, computed} from 'vue'
import moment from 'moment'

ChartJS.register(
  CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend, zoomPlugin, Filler
)

ChartJS.register(zoomPlugin)

export default {
  name: 'SpeedTab',
  components: {
    Line
  },
  emits: ['select-message'],
  props: {
    objectName: String,
    messages: Array,
    dateFrom: Object,
    dateTo: Object,
  },
  setup(props, {emit}) {

    const lineChart = ref(null);

    const chartData = computed(() => {
      const labels = []
      const data = []
      const format = props.dateFrom.format('DD.MM.YYYY') === props.dateTo.format('DD.MM.YYYY') ? 'HH:mm' : 'DD.MM'
      props.messages.map(message => {
        labels.push(moment(message.time).format(format))
        data.push(message.speed)
      })

      return {
        labels: labels,
        datasets: [{
          label: 'Скорость, км/ч',
          data: data,
          fill: true,
          hoverBackgroundColor: '#F21313',
          backgroundColor: 'rgba(255, 255, 255, 0.3)',
          borderColor: '#008080',
          tension: 0.1,
          borderWidth: 1
        }]
      }
    })

    const handleChartClick = (event, element) => {
      if (element && element[0]) {
        const message = props.messages[element[0].index]
        emit('select-message', {id: message.id, lat: message.lat, lon: message.lon})
      }
    }
    const chartOptions = computed(() => ({
      responsive: true,
      maintainAspectRatio: false,
      onClick: handleChartClick,
      plugins: {
        tooltip: {
          callbacks: {
            title: context => {
              const message = props.messages[context[0].dataIndex]
              return message
                ? `Время: ${moment(message.time).format('DD.MM.YYYY HH:mm:ss')}`
                : 'Ошибка чтения данных'
            },
            label: context => {
              const message = props.messages[context.dataIndex]
              return message ? `Скорость: ${message.speed} км/ч` : 'Ошибка чтения данных'
            }
          }
        },
        zoom: {
          limits: {
            x: {min: 0, max: 'original'},
            y: {min: 0, max: 'original'}
          },
          zoom: {
            wheel: {
              enabled: true,
            },
            drag: {
              enabled: true,
            },
            pinch: {
              enabled: true
            },
            mode: 'xy',
          }
        }
      },
      scales: {
        y: {
          title: {
            display: true,
            text: 'Скорость, км/ч',
            font: {
              weight: 'bold',
              size: 15,
            }
          }
        },
        x: {
          title: {
            display: true,
            text: 'Дата',
            font: {
              weight: 'bold',
              size: 15,
            }
          }
        }
      }
    }))

    const resetChartZoom = () => lineChart.value.chart.resetZoom()

    const saveChartToPng = () => {
      let canvas = lineChart.value.chart.canvas.toDataURL('image/png')
      let link = document.createElement('a')
      link.download = `Объект ${props.objectName}, График скорости`
      link.href = canvas
      link.click()
    }

    return {
      chartData,
      chartOptions,
      lineChart,
      resetChartZoom,
      saveChartToPng
    }
  },
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
.chart-container {
  flex-grow: 1;
  min-height: 0;

  > div {
    position: relative;
    height: 100%;
  }
}
</style>
