<template>
  <NavTemplate/>
  <div class="container">
    <div class="top-line d-flex align-items-center flex-wrap">
      <div class="left d-flex flex-wrap">
        <div class="click-btn d-flex justify-content-center align-items-center add-btn" @click="open_pop_up.add=true">
          <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
            <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
              222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
          </svg>
        </div>
        <div class="click-btn d-flex justify-content-center align-items-center delete-btn" @click="deleteItem();">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315"><g><path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"></path><path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"></path><path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"></path><path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"></path></g></svg>
        </div>
        <div class="click-btn d-flex justify-content-center align-items-center download-btn">
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 325 325" style="enable-background:new 0 0 325 325;" xml:space="preserve">
          <g id="XMLID_786_">
            <g>
              <g>
                <path d="M260.232,83.385h-54.253V2.5h-86.957v80.885H64.769L162.5,214.211L260.232,83.385z M139.021,103.385V22.5h46.957v80.885
                  h34.349L162.5,180.793l-57.827-77.408H139.021z"/>
                <path d="M260,182.5v70H65v-70H0v140h325v-140H260z M305,302.5H20v-100h25v70h235v-70h25V302.5z"/>
              </g>
            </g>
          </g>
        </svg>
        </div>
      </div>
      <div class="right">
        <form class="d-flex align-items-center form-find">
          <div>
            <input
              type="text"
              class="form-control"
              placeholder="Введите название"
              v-model="search"
              @keyup="getData"
            >
          </div>
          <button type="submit" class="btn btn-primary">
            <svg width="12px" height="12px" viewBox="0 0 12 12" enable-background="new 0 0 12 12" id="Слой_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M7,0C4.2385864,0,2,2.2385864,2,5c0,1.2001343,0.4402466,2.2866211,1.1450195,3.1483765L0,11.2929688  L0.7070313,12l3.1450806-3.1446533C4.7138062,9.5598755,5.8001099,10,7,10c2.7614136,0,5-2.2385864,5-5S9.7614136,0,7,0z M7,9  C4.7943726,9,3,7.2056274,3,5s1.7943726-4,4-4s4,1.7943726,4,4S9.2056274,9,7,9z"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>

  <UsersTable
    :users="arr_data"
    :additional-info="dict"
    @row-click="rowClick"
    @row-double-click="rowDoubleClick"
    @permissions-click="permissionsClick"
  />

  <transition name="fade">
    <div class="modal fade show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="open_pop_up.add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавление Аккаунта</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.add = false;closeForm();"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <table class="table no-border">
                <tbody>
                <tr>
                  <td><label class="form-label m-0 left-text">Имя</label></td>
                  <td><input :class="[{ 'is-invalid': valid_error.add.name },'form-control']" :value="add_arr.name" @input="add_arr.name=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text">Комментарии</label></td>
                  <td><input class="form-control" :value="add_arr.comment" @input="add_arr.comment=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">Пароль:</label></label></td>
                  <td class="d-flex align-items-center">
                    <input type="password" :class="[{ 'is-invalid': valid_error.add.password },'form-control flex-1']" :value="add_arr.password" @input="add_arr.password=$event.target.value;"/>
                    <input class="form-check-input ms-3 mt-0 me-1" type="checkbox" :value="add_arr.change_password" v-model="add_arr.change_password">
                    <label class="form-label text-nowrap mb-0">Разрешить изменение</label>
                  </td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">e-mail:</label></label></td>
                  <td><input type="email" :class="[{ 'is-invalid': valid_error.add.email },'form-control']" :value="add_arr.email" @input="add_arr.email=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">Телефон:</label></label></td>
                  <td><input class="form-control" :value="add_arr.phone" @input="add_arr.phone=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Тип</label></td>
                  <td>
                    <select :class="[{ 'is-invalid': valid_error.add.role },'form-select']" :value="add_arr.role" @change="add_arr.role=$event.target.value;">
                      <option value="" disabled>Выберите тип учётной записи</option>
                      <option v-for="item in dict.roles" :value="item.id">{{item.name}}</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Основная учетная запись</label></td>
                  <td>
                    <select :class="[{ 'is-invalid': valid_error.add.account },'form-select']" :value="add_arr.account" @change="add_arr.account=$event.target.value;">
                      <option value="">- нет -</option>
                      <option v-for="item in dict.accounts" :value="item.id">{{item.name}}</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label class="form-check-label text-nowrap left-text">Включен</label>
                  </td>
                  <td class="d-flex align-items-center justify-content-between">
                    <input class="form-check-input" type="checkbox" :value="add_arr.block" v-model="add_arr.block">
                    <label class="form-label ms-3 text-nowrap mb-0">Причина блокировки</label>
                    <input class="form-control ms-2 flex-1" :value="add_arr.reason_block" @input="add_arr.reason_block=$event.target.value;"/>
                  </td>
                </tr>
                </tbody>
              </table>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="open_pop_up.add=false;">Закрыть</button>
            <button type="button" class="btn btn-success" @click="addItem();$event.preventDefault();">Сохранить</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
  <transition name="fade">
    <div class="modal fade show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="open_pop_up.change">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Редактирование Аккаунта</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.change=false;validate.change=false;"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <table class="table no-border">
                <tbody>
                <tr>
                  <td><label class="form-label m-0 left-text">Имя</label></td>
                  <td><input :class="[{ 'is-invalid': valid_error.change.name },'form-control']" :value="change_arr.name" @input="change_arr.name=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text">Комментарии</label></td>
                  <td><input class="form-control" :value="change_arr.comment" @input="change_arr.comment=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">Пароль:</label></label></td>
                  <td class="d-flex align-items-center">
                    <input type="password" :class="[{ 'is-invalid': valid_error.change.password },'form-control flex-1']" :value="change_arr.password" @input="change_arr.password=$event.target.value;"/>
                    <input class="form-check-input ms-3 mt-0 me-1" type="checkbox" :value="change_arr.change_password" v-model="change_arr.change_password">
                    <label class="form-label text-nowrap mb-0">Разрешить изменение</label>
                  </td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">e-mail:</label></label></td>
                  <td><input type="email" :class="[{ 'is-invalid': valid_error.change.email },'form-control']" :value="change_arr.email" @input="change_arr.email=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text"><label class="form-label m-0 left-text">Телефон:</label></label></td>
                  <td><input class="form-control" :value="change_arr.phone" @input="change_arr.phone=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Тип</label></td>
                  <td>
                    <select :class="[{ 'is-invalid': valid_error.change.role },'form-select']" :value="change_arr.role" @change="change_arr.role=$event.target.value;">
                      <option value="" disabled>Выберите тип учётной записи</option>
                      <option v-for="item in dict.roles" :value="item.id">{{item.name}}</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Основная учетная запись</label></td>
                  <td>
                    <select :class="[{ 'is-invalid': valid_error.change.account },'form-select']" :value="change_arr.account" @change="change_arr.account=$event.target.value;">
                      <option value="">- нет -</option>
                      <option v-for="item in dict.accounts" :value="item.id">{{item.name}}</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label class="form-check-label text-nowrap left-text">Включен</label>
                  </td>
                  <td class="d-flex align-items-center justify-content-between">
                    <input class="form-check-input" type="checkbox" :value="change_arr.block" v-model="change_arr.block">
                    <label class="form-label ms-3 text-nowrap mb-0">Причина блокировки</label>
                    <input class="form-control ms-2 flex-1" :value="change_arr.reason_block" @input="change_arr.reason_block=$event.target.value;"/>
                  </td>
                </tr>
                </tbody>
              </table>
            </form>
          </div>
          <div class="modal-footer d-flex justify-space-between">
            <div>
              <button
                type="button"
                class="btn btn-outline-secondary"
                @click="showUserPermissionModal"
              >Права</button>
            </div>
            <div>
              <button
                type="button"
                class="btn btn-secondary mr-2"
                data-bs-dismiss="modal"
                @click="open_pop_up.change=false;validate.change=false;"
              >Закрыть</button>
              <button
                type="button"
                class="btn btn-success"
                @click="changeItem();$event.preventDefault();"
              >Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <users-permission-modal
    :user="editableUser"
    :visible="userPermissionModalVisible"
    @hide="onUserPermissionModalHide"
  ></users-permission-modal>

</template>

<script>
import NavTemplate from '@/js/components/Nav.vue'
import appToast from '@/js/composables/toast-notification'
import UsersTable from '@/js/views/panel/users/UsersTable.vue'
import {ref} from 'vue'
import UsersPermissionModal from '@/js/views/panel/users/permission/UsersPermissionModal.vue'

export default {
  name: 'Users',
  components: {
    UsersPermissionModal, NavTemplate, UsersTable
  },
  setup() {
    const userPermissionModalVisible = ref(false)
    const editableUser = ref(null)

    const { toastSuccess, toastError, toastWarning } = appToast()
    const showUserPermissionModal = () => userPermissionModalVisible.value = true
    const onUserPermissionModalHide = () => userPermissionModalVisible.value = false

    const permissionsClick = account => {
      editableUser.value = account
      showUserPermissionModal()
    }

    return {
      userPermissionModalVisible,
      editableUser,

      toastSuccess,
      toastError,
      toastWarning,
      showUserPermissionModal,
      onUserPermissionModalHide,
      permissionsClick,
    }
  },
  data(){
    return{
      arr_data:[],
      open_pop_up:{
        add:false,
        change:false
      },
      add_arr:{
        name:"",
        comment:"",
        password:"",
        change_password:false,
        email:"",
        phone:"",
        role:"",
        account:"",
        block:false,
        reason_block:"",
      },
      change_arr:{
        name:"",
        comment:"",
        password:"",
        change_password:false,
        email:"",
        phone:"",
        role:"",
        account:"",
        block:false,
        reason_block:"",
      },
      dict:{
        roles:{},
        accounts:{},
      },
      validate:{
        add:false,
        change:false,
      },
      valid_error:{
        add:{
          name:false,
          password:false,
          email:false,
          role:false,
        },
        change:{
          name:false,
          password:false,
          email:false,
          role:false,
        }
      },
      active_elem:-1,
      search: null,
    }
  },
  methods:{
    checkLimit(type,idx){
      if(type=="change"){
        if(this.change_arr.limit_debt_type!=idx) this.change_arr.limit_debt="";
        this.change_arr.limit_debt_type=idx;
      }
      else {
        if(this.add_arr.limit_debt_type!=idx) this.add_arr.limit_debt="";
        this.add_arr.limit_debt_type=idx;
      }

    },
    openUserEditModal(item) {
      this.change_arr = item
      // this.change_arr.block = !this.change_arr.block
      this.open_pop_up.change = true
      this.editableUser = this.change_arr
    },
    convertDateTimeToLocal(item){
      let local_time = this.$moment.utc(item).local().format("DD.MM.YYYY HH:mm:ss");
      if (local_time == 'Invalid date'){
        local_time = '';
      }
      return local_time;
    },
    getData() {
      let fData = new FormData()

      if (this.search) {
        fData.append('search', this.search)
      }

      axios.post('/user/get',fData)
        .then(response => {
          let data = response.data
          if (data.result) {
            this.arr_data = []
            for (let i in data['data']) {
              let item = data['data'][i]
              item = this.parseNull(item)
              item['last_login'] = this.convertDateTimeToLocal(item['last_login'])
              this.arr_data.push(item)
            }
          } else {
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          }
        })
        .catch(error => {
          this.toastWarning('Что-то пошло не так. Попробуйте позже')
          console.log(error)
        })
        .finally(() => (this.loading = false))
    },
    addItem(){
      let fData = new FormData();
      let current_arr = this.add_arr;
      if(this.isEmpty(current_arr.name) || this.isEmpty(current_arr.password) || this.isEmpty(current_arr.email) || this.isEmpty(current_arr.role)){
        this.validate.add=true;
        this.checkErrorsAdd();
        return;
      }

      fData.append("name",current_arr.name);
      fData.append("comment",current_arr.comment);
      fData.append("password",current_arr.password);
      fData.append("email",current_arr.email);
      fData.append("phone",current_arr.phone);
      fData.append("role",current_arr.role);
      fData.append("account",current_arr.account);
      fData.append("block",current_arr.block);
      fData.append("reason_block",current_arr.reason_block);

      axios.post('/user/add',fData)
        .then(response => {
          let data = response.data;
          if(data.result==true){
            this.arr_data.push(this.parseNull(data.data));
            this.toastSuccess('Аккаунт создан')
            this.open_pop_up.add=false;
            this.validate.add=false;
            this.add_arr={
              name:"",
              comment:"",
              password:"",
              change_password:false,
              email:"",
              phone:"",
              role:"",
              account:"",
              block:false,
              reason_block:"",
            }
          }
          else if(data.code=="email_exist"){
            this.toastError('Ошибка. Пользователь с таким e-mail уже существует')
          }
          else{
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          }
        })
        .catch(error => {
          this.toastWarning('Что-то пошло не так. Попробуйте позже')
          console.log(error);
        })
        .finally(() => (this.loading = false));
    },
    changeItem(){
      let fData = new FormData();
      let current_arr = this.change_arr;
      if(this.isEmpty(current_arr.name) || this.isEmpty(current_arr.password) || this.isEmpty(current_arr.email) || this.isEmpty(current_arr.role)){
        this.validate.add=true;
        this.checkErrorsChange();
        return;
      }

      fData.append("name",current_arr.name);
      fData.append("comment",current_arr.comment);
      fData.append("password",current_arr.password);
      fData.append("email",current_arr.email);
      fData.append("phone",current_arr.phone);
      fData.append("role",current_arr.role);
      fData.append("account",current_arr.account);
      fData.append("block",current_arr.block);
      fData.append("reason_block",current_arr.reason_block);
      fData.append("id",current_arr.id);

      axios.post('/user/change',fData)
        .then(response => {
          let data = response.data;
          if(data.result==true){
            this.toastSuccess('Пользователь изменён')
            this.arr_data[this.change_arr.index]=this.parseNull(data.data);
          }
          else{
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          }
        })
        .catch(error => {
          this.toastWarning('Что-то пошло не так. Попробуйте позже')
          console.log(error);
        })
        .finally(() => (this.loading = false));
    },
    deleteItem(){
      if(!confirm("Вы действительно хотите удалить пользователя?")) return false;

      let fData = new FormData();
      fData.append("id",this.arr_data[this.active_elem].id);

      axios.post('/user/delete',fData)
        .then(response => {
          let data = response.data;
          if(data.result==true){
            this.toastSuccess('Пользователь удалён')
            this.arr_data.splice(this.active_elem, 1);
            this.active_elem=-1;
          }
          else{
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          }
        })
        .catch(error => {
          this.toastWarning('Что-то пошло не так. Попробуйте позже')
          console.log(error);
        })
        .finally(() => (this.loading = false));
    },
    init(){
      let fData = new FormData();

      axios.post('/user/init',fData)
        .then(response => {
          let data = response.data;
          if(data.result==true){
            this.dict.accounts=data.accounts;
            this.dict.roles=data.roles;
            this.getData();
          }
          else{
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          }
        })
        .catch(error => {
          this.toastWarning('Что-то пошло не так. Попробуйте позже')
          console.log(error);
        })
        .finally(() => (this.loading = false));
    },
    checkErrorsAdd(){
      if(this.validate.add==true){
        for(let key in this.valid_error.add){
          if(this.isEmpty(this.add_arr[key])) this.valid_error.add[key]=true;
          else this.valid_error.add[key]=false;
        }
      }
    },
    checkErrorsChange(){
      if(this.validate.change==true){
        for(let key in this.valid_error.change){
          if(this.isEmpty(this.change_arr[key])) this.valid_error.change[key]=true;
          else this.valid_error.change[key]=false;
        }
      }
    },
    isEmpty(str){
      if(typeof str == "undefined") return true;
      if(this.isAN(str)) return false;
      if(str.length==0 || str=="" || str.trim()=="") return true;
      return false;
    },
    isAN(value) {
      return (value instanceof Number||typeof value === 'number') && !isNaN(value);
    },
    parseNull(data){
      for(let i_c in data){
        if(data[i_c]=="null" || data[i_c]==null) data[i_c]="";
      }
      return data;
    },
    rowClick(active) {
      this.active_elem = active
    },
    rowDoubleClick(item) {
      this.openUserEditModal(item)
    },
    closeForm() {
            this.add_arr = {
                name: "",
                comment: "",
                password: "",
                change_password: false,
                email: "",
                phone: "",
                role: "",
                account: "",
                block: false,
                reason_block: "",
      };
    },
  },
  watch: {
    add_arr:{
      handler: function (newCar, oldCar) {
        this.checkErrorsAdd();
      },
      deep: true,
    },
    change_arr:{
      handler: function (newCar, oldCar) {
        this.checkErrorsChange();
      },
      deep: true,
    },
  },
  mounted() {
    this.init();
  }
}
</script>
