<template>
  <v-toolbar
    border
    density="compact"
    class="toolbar"
  >
    <div class="toolbar-horizontal-box d-flex align-items-center justify-space-between w-100">
      <div class="left-box-content d-flex align-items-center">
        <div class="logo">
          <img src="@/img/toolbar-logo.png">
        </div>
        <div class="separator"></div>
        <div class="menu d-flex align-items-center">
          <div
            v-for="item in menuItems"
            class="menu-item panel d-flex align-items-center justify-content-center"
          >
            <template v-if="item.items && item.items.length">
              <v-menu
                anchor="bottom end"
                rounded
                class="context-menu"
                open-on-hover
                open-on-click
                close-on-back
                close-on-content-click
              >
                <template #activator="{ props }">
                  <div
                    class="d-flex align-items-center"
                    v-bind="props"
                    @click.stop
                  >
                    <img :src="item.icon">
                    <div class="title mr-1">{{ item.title }}</div>
                    <img src="@/img/arrow-down.png">
                  </div>
                </template>
                <v-list class="context-menu-list p-0">
                  <div class="context-menu-separator h-100"></div>
                  <div class="pt-1 pb-1">
                    <v-list-item
                      v-for="(subItem, index) in item.items"
                      :key="index"
                      class="d-flex align-items-center cursor-pointer"
                      @click="onMenuReportItemClick"
                    >
                      <template #prepend="{ isActive }">
                        <div class="icon-wrapper">
                          <img :src="subItem.icon">
                        </div>
                      </template>
                      <template #default="{ isActive }">
                        <v-list-item-title :title="subItem.title">{{ subItem.text }}</v-list-item-title>
                      </template>
                    </v-list-item>
                  </div>
                </v-list>
              </v-menu>
            </template>
            <template v-else>
              <img :src="item.icon">
              <div class="title mr-1">{{ item.title }}</div>
            </template>
          </div>
        </div>
      </div>
      <div class="right-box-content d-flex align-items-center">
        <div
          v-if="userName"
          class="account"
        >
          <span>Аккаунт:</span>
          <strong class="ml-1">{{ userName }}</strong>
        </div>
        <v-btn
          class="ml-2"
          @click="logout"
        >Выйти</v-btn>
      </div>
    </div>
  </v-toolbar>
</template>

<script>
import 'vuetify/styles'
import authManager from "@/js/composables/auth-manager";

export default {
  name: 'UserNav',
  emits: ['main-menu-report-click'],
  data() {
    return {
      userName: null,
      menuItems: [
        {
          title: 'Отчеты',
          icon: new URL('@/img/main-menu/report.png', import.meta.url),
          items: [
            {
              text: 'Общий отчёт',
              title: 'Новый общий отчет',
              type: 'common',
              icon: new URL('@/img/context-menu/coldiag.png', import.meta.url)
            },
            {
              text: 'Отчёт по топливу',
              title: 'Новый отчет по данным топливных датчиков',
              type: 'fuel-sensor',
              icon: new URL('@/img/context-menu/coldiag.png', import.meta.url)
            },
            {
              text: 'Отчёт с группировкой',
              title: 'Новый отчет с группировкой по дням',
              type: 'by-days',
              icon: new URL('@/img/context-menu/coldiag.png', import.meta.url)
            },
            {
              text: 'Отчёт по адресам(ГУИС)',
              title: 'Новый отчет по посещенным адресам',
              type: 'visited-addresses',
              icon: new URL('@/img/context-menu/coldiag.png', import.meta.url)
            },
            {
              text: 'Отчёт по группе объектов',
              title: 'Новый отчет по группе объектов',
              type: 'by-object-group',
              icon: new URL('@/img/context-menu/coldiag.png', import.meta.url)
            },
          ]
        },
        {
          title: 'Уведомления',
          icon: new URL('@/img/main-menu/notif.png', import.meta.url),
          items: [
            {
              text: 'История уведомлений',
              title: 'Просмотреть историю сообщений и уведомлений',
              icon: new URL('@/img/context-menu/table.png', import.meta.url)
            },
            {
              text: 'Правила уведомлений',
              title: 'Просмотр/редактирование правил уведомлений о событиях',
              icon: new URL('@/img/context-menu/pencil.png', import.meta.url)
            },
            {
              text: 'Настройки уведомлений',
              title: 'Настройки уведомлений',
              icon: new URL('@/img/context-menu/settings.png', import.meta.url)
            }
          ]
        },
        {
          title: 'Инструменты',
          icon: new URL('@/img/main-menu/geozone.png', import.meta.url),
          items: [
            {
              text: 'Геозоны',
              title: 'Просмотр/редактирование геозон',
              icon: new URL('@/img/context-menu/geozone.png', import.meta.url)
            }
          ]
        },
        {
          title: 'Группы объектов',
          icon: new URL('@/img/main-menu/car.png', import.meta.url),
        },
        {
          title: 'Поддержка',
          icon: new URL('@/img/main-menu/question.png', import.meta.url),
          items: [
            {
              text: 'Новая заявка',
              title: 'Новая заявка',
              icon: new URL('@/img/context-menu/pencil.png', import.meta.url)
            },
            {
              text: 'Мои заявки',
              title: 'Мои заявки',
              icon: new URL('@/img/context-menu/table.png', import.meta.url)
            }
          ]
        },
      ]
    }
  },
  mounted() {
    this.loadUserName()
  },
  methods: {
    loadUserName() {
      let user = localStorage.getItem('user')
      user = user ? JSON.parse(user) : null
      this.userName = user && user.name ? user.name : null
    },
    onMenuReportItemClick() {
      this.$emit('main-menu-report-click')
    },
  },
  setup() {
    const { logout } = authManager()
    return {
      logout
    }
  }
}
</script>

<style lang='scss' scoped>
.toolbar {
  font-size: 11px;
  padding: 0 10px;
  border-color: #bcb0b0;
  background-color: #d8d8d8;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #e6e6e6), color-stop(100%, #efefef));
  background-image: -moz-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: -o-linear-gradient(to top, #e6e6e6, #efefef);
  background-image: linear-gradient(to top, #e6e6e6, #efefef);
  .toolbar-horizontal-box {
    height: 36px;
    .left-box-content {
      .panel {
        &.menu-item:not(:last-child) {
          margin-right: 4px;
          padding-right: 6px;
        }
        .title {
          margin-left: 4px;
          font-size: 11px;
          font-weight: normal;
          font-family: tahoma, arial, verdana, sans-serif;
          color: #333333;
        }
      }
    }
  }
}
</style>
