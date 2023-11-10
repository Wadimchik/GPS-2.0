<template>
  <div @dblclick.stop="showDialog">
    <div class="item-balance">
      {{ itemBalance }} р.
    </div>
    <v-dialog
      width="50%"
      v-model="dialog"
    >
      <v-sheet>
        <v-card class="v-card-form">
          <v-card-title class="p-4">
            Изменение баланса
            <v-btn
              variant="outlined"
              class="float-right"
              @click="dialog = false"
            >X</v-btn>
          </v-card-title>
          <v-form
            method="POST"
            ref="formBalanceChange"
            class="p-4 pt-0"
            @submit.prevent="changeBalance();"
          >
            <v-select
              v-model="operationSelect"
              :items="items"
              :rules="[(v) => !!v || 'Выберите тип операции']"
              label="Тип операции"
              required
            ></v-select>
            <v-text-field
              v-model="amountValue"
              type="number"
              label="Сумма"
              :rules="[
                (v) => !!v || 'Введите сумму',
                (v) => v != 0 || 'Выберите сумму отличную от 0',
              ]"
              required
            ></v-text-field>
            <v-text-field
              v-model="operationComment"
              label="Комментарий"
            ></v-text-field>

            <v-btn
              type="submit"
              class="mb-4 float-right"
            >Исполнить операцию</v-btn>
          </v-form>
        </v-card>
        <v-card-title class="p-4">История баланса</v-card-title>

        <div class="p-4 pt-0">
          <table class="table">
            <thead>
            <tr>
              <th scope="col">Тип</th>
              <th scope="col">Сумма</th>
              <th scope="col">Баланс</th>
              <th scope="col">Время</th>
              <th scope="col">Комментарий</th>
            </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item) in balanceHistory"
                class="cursor-pointer"
              >
                <th scope="row">{{ item.operation_type.name }}</th>
                <td>{{ item.summ }}</td>
                <td>{{ item.balance }}</td>
                <td>{{ formatDate(item.created_at) }}</td>
                <td>{{ item.comment }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </v-sheet>
    </v-dialog>
  </div>
</template>

<script>
import appToast from '@/js/composables/toast-notification'

export default {
  name: 'BalanceDialog',
  props: ['balance', 'id'],
  setup() {
    const { toastSuccess, toastWarning } = appToast()
    return {
      toastSuccess,
      toastWarning,
    }
  },
  data() {
    return {
      operationSelect: null,
      operationComment: '',
      amountValue: 0,
      items: ['Зачислить на счёт'],
      dialog: false,
      itemBalance: this.balance,
      balanceHistory: []
    }
  },
  methods: {
    showDialog() {
      this.operationSelect = null
      this.operationComment = ''
      this.amountValue = 0

      this.getBalanceHistory()

      this.dialog = true
    },
    changeBalance() {
      let fData = new FormData()
      fData.append('id', this.id)
      fData.append('amount', this.amountValue)
      fData.append('operation_type', this.operationSelect)
      fData.append('operation_comment', this.operationComment)

      if (this.operationSelect === 'Зачислить на счёт') {
        axios.post('/account/change-balance', fData)
          .then(response => {
            let data = response.data
            if (data) {
              this.itemBalance = data.balance
              this.getBalanceHistory()
              this.toastSuccess('Баланс успешно изменен')
            } else {
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
            }
          })
          .catch(error => {
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
            console.log(error)
          })
      }
    },
    getBalanceHistory() {
      axios.get('/account/balance-history/' + this.id)
        .then(response => this.balanceHistory = response.data.result ? response.data.data : [])
    },
    formatDate(datetime) {
      return datetime ? this.$moment(datetime).format('DD-MM-YYYY HH:mm:ss') : null
    }
  }
}
</script>

<style>
.v-card-form {
  border-radius: 0 !important;
}

.item-balance:hover {
  text-decoration: underline;
}
</style>
