<template>
  <div class="report-toolbar w-100 d-flex align-items-center">
    <div
      class="icon-wrapper panel"
      title="Свернуть все отчеты"
      @click="hideAllReports"
    >
      <img src="@/img/hide-all-reports.png">
    </div>
    <div class="separator"></div>
    <template v-if="reports.length">
      <div class="reports-wrapper d-flex align-items-center">
        <div
          v-for="(report, index) in reports"
          class="report-item panel d-flex align-items-center justify-content-center"
          :class="{'rolled-down': report.rolledDown}"
          @click="openReportWindow(report.id)"
        >
          <img src="@/img/coldiag_24.png">
          <div class="title">
            <strong>{{ index + 1 }}. </strong>
            {{ report.title }}
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: 'ReportToolbar',
  emits: ['open-report-window', 'hide-all-reports'],
  props: {
    reports: Array
  },
  data() {
    return {
    }
  },
  methods: {
    openReportWindow(reportId) {
      this.$emit('open-report-window', reportId)
    },
    hideAllReports() {
      this.$emit('hide-all-reports')
    }
  }
}
</script>

<style lang='scss' scoped>
.report-toolbar {
  height: 46px;
  font-size: 11px;
  padding: 2px 10px;
  border: 1px solid #bcb0b0;
  background-color: #d8d8d8;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e6e6e6), color-stop(100%, #efefef));
  background-image: -moz-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: -o-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: linear-gradient(to top, #e6e6e6, #efefef);
  .panel {
    &.report-item:not(:last-child) {
      margin-right: 4px;
      padding-right: 6px;
    }
    &.rolled-down {
      opacity: 0.5;
    }
    &:hover {
      opacity: 1;
    }
    .title {
      margin-left: 4px;
      font-size: 11px;
      font-weight: normal;
      font-family: tahoma, arial, verdana, sans-serif;
      color: #333333;
    }
  }
  .icon-wrapper {
    img {
      opacity: 0.5;
      &:hover {
        opacity: 1;
      }
    }
  }
}
</style>
