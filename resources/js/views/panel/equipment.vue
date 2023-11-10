<template>
  <NavTemplate/>
  <div class="container">
    <div class="top-line d-flex align-items-center flex-wrap">
      <div class="left d-flex flex-wrap">
        <div class="click-btn d-flex justify-content-center align-items-center add-btn" @click="open_pop_up.add=true;active_tab=1">
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
            <input type="text" class="form-control" placeholder="Введите название">
          </div>
          <button type="submit" class="btn btn-primary">
            <svg width="12px" height="12px" viewBox="0 0 12 12" enable-background="new 0 0 12 12" id="Слой_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M7,0C4.2385864,0,2,2.2385864,2,5c0,1.2001343,0.4402466,2.2866211,1.1450195,3.1483765L0,11.2929688  L0.7070313,12l3.1450806-3.1446533C4.7138062,9.5598755,5.8001099,10,7,10c2.7614136,0,5-2.2385864,5-5S9.7614136,0,7,0z M7,9  C4.7943726,9,3,7.2056274,3,5s1.7943726-4,4-4s4,1.7943726,4,4S9.2056274,9,7,9z"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
  <table class="table mt-5">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Тип устройства</th>
      <th scope="col">Учетная запись</th>
      <th scope="col">Объект</th>
      <th scope="col">Марка</th>
      <th scope="col">Модель</th>
      <th scope="col">Серийный номер</th>
      <th scope="col">IMEI</th>
      <th scope="col">Абоненский номер</th>
      <th scope="col">Прошивка</th>
      <th scope="col">История</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="(item,idx) in arr_data" class="cursor-pointer" @click="active_elem=idx;" :class="[{'table-danger':item.block==1},{'active-row':idx==active_elem}]" @dblclick="fadeChange(idx);">
      <th scope="row">{{item.id}}</th>
      <td>{{returnValueOrNull(dict.types,item.type)}}</td>
      <td>{{returnValueOrNull(dict.accounts,item.account)}}</td>
      <td>{{returnValueOrNull(dict.objects,item.object)}}</td>
      <td>{{returnValueOrNull(dict.brands,item.brand)}}</td>
      <td>{{returnValueOrNull(dict.models,item.model)}}</td>
      <td>{{item.serial_number}}</td>
      <td>{{item.imei}}</td>
      <td>{{item.sim_number}}</td>
      <td>{{item.firmware}}</td>
      <td>0</td>
    </tr>
    </tbody>
  </table>
  <transition name="fade">
    <div class="modal fade show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="open_pop_up.add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Добавление Оборудования</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.add=false"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <div class="d-flex mb-3 align-items-center">
                <label class="form-label m-0 left-text w-auto me-5">Пользователь:</label>
                <select :class="[{ 'is-invalid': valid_error.add.account },'form-select flex-1']" :value="add_arr.account" @change="add_arr.account=$event.target.value;">
                  <option value="" disabled>Выберите учётную запись</option>
                  <option v-for="item in dict.accounts" :value="item.id">{{item.name}}</option>
                </select>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a :class="[{'active':active_tab==1},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=1">Основные сведенья</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==2},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=2">Характеристики устройства</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==3},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=3">SIM-карта</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==4},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=4">Место установки</a>
                </li>
              </ul>
              <div class="form-tabs">
                <div class="tab" v-if="active_tab==1">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Сосбветнник:</label></td>
                      <td><input class="form-control" :value="add_arr.owner" @input="add_arr.owner=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Основание использования:</label></td>
                      <td><input class="form-control" :value="add_arr.reason_use" @input="add_arr.reason_use=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Дата продажи:</label></td>
                      <td>
                        <DatePicker v-model="add_arr.date_sale" :columns="2" :masks="masks">
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"/>
                          </template>
                        </DatePicker></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Работа:</label></td>
                      <td><input class="form-control" :value="add_arr.work" @input="add_arr.work=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Дата работы:</label></td>
                      <td>
                        <DatePicker v-model="add_arr.date_work" :columns="2" :masks="masks">
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"/>
                          </template>
                        </DatePicker>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Примечание:</label></td>
                      <td><input class="form-control" :value="add_arr.comment" @input="add_arr.comment=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-else-if="active_tab==2">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Тип:</label></td>
                      <td>
                        <select :class="[{ 'is-invalid': valid_error.add.type },'form-select']" :value="add_arr.type" @change="add_arr.type=$event.target.value;add_arr.brand=0;add_arr.model=0;">
                          <option value="" disabled>Выберите тип</option>
                          <option v-for="item in dict.types_select" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Марка:</label></td>
                      <td>
                        <select class="form-select" :value="add_arr.brand" @change="add_arr.brand=$event.target.value;add_arr.model=0;">
                          <option value="" disabled>Выберите марку</option>
                          <option v-if="add_arr.type!=0" v-for="item in dict.types_select[add_arr.type].brands" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Марка:</label></td>
                      <td>
                        <select class="form-select" :value="add_arr.model" @change="add_arr.model=$event.target.value;">
                          <option value="" disabled>Выберите Модель</option>
                          <option v-if="add_arr.brand!=0 && add_arr.type!=0" v-for="item in dict.types_select[add_arr.type].brands[add_arr.brand].models" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Серийный номер:</label></td>
                      <td><input class="form-control" :value="add_arr.serial_number" @input="add_arr.serial_number=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">IMEI:</label></td>
                      <td><input class="form-control" :value="add_arr.imei" @input="add_arr.imei=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Прошивка:</label></td>
                      <td><input class="form-control" :value="add_arr.firmware" @input="add_arr.firmware=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Конфигурация:</label></td>
                      <td><input class="form-control" :value="add_arr.config" @input="add_arr.config=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Логин:</label></td>
                      <td><input class="form-control" :value="add_arr.login" @input="add_arr.login=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Пароль:</label></td>
                      <td><input class="form-control" :value="add_arr.password" @input="add_arr.password=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-if="active_tab==3">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Сосбветнник:</label></td>
                      <td><input class="form-control" :value="add_arr.sim_owner" @input="add_arr.sim_owner=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Оператор:</label></td>
                      <td><input class="form-control" :value="add_arr.sim_operator" @input="add_arr.sim_operator=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Абонентский номер:</label></td>
                      <td><input class="form-control" :value="add_arr.sim_number" @input="add_arr.sim_number=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">ICCID:</label></td>
                      <td><input class="form-control" :value="add_arr.sim_iccid" @input="add_arr.sim_iccid=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Примечание:</label></td>
                      <td><input class="form-control" :value="add_arr.sim_comment" @input="add_arr.sim_comment=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-if="active_tab==4">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Место установки:</label></td>
                      <td><input class="form-control" :value="add_arr.installation_location" @input="add_arr.installation_location=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
            <h5 class="modal-title">Редактирование Оборудования</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.change=false;validate.change=false;"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <div class="d-flex mb-3 align-items-center">
                <label class="form-label m-0 left-text w-auto me-5">Пользователь:</label>
                <select :class="[{ 'is-invalid': valid_error.change.account },'form-select flex-1']" :value="change_arr.account" @change="change_arr.account=$event.target.value;">
                  <option value="" disabled>Выберите учётную запись</option>
                  <option v-for="item in dict.accounts" :value="item.id">{{item.name}}</option>
                </select>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a :class="[{'active':active_tab==1},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=1">Основные сведенья</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==2},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=2">Характеристики устройства</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==3},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=3">SIM-карта</a>
                </li>
                <li class="nav-item">
                  <a :class="[{'active':active_tab==4},'nav-link']" href="#" @click="$event.preventDefault(); active_tab=4">Место установки</a>
                </li>
              </ul>
              <div class="form-tabs">
                <div class="tab" v-if="active_tab==1">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Сосбветнник:</label></td>
                      <td><input class="form-control" :value="change_arr.owner" @input="change_arr.owner=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Основание использования:</label></td>
                      <td><input class="form-control" :value="change_arr.reason_use" @input="change_arr.reason_use=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Дата продажи:</label></td>
                      <td>
                        <DatePicker v-model="change_arr.date_sale" :columns="2" :masks="masks">
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"/>
                          </template>
                        </DatePicker>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Работа:</label></td>
                      <td><input class="form-control" :value="change_arr.work" @input="change_arr.work=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Дата работы:</label></td>
                      <td>
                        <DatePicker v-model="change_arr.date_work" :columns="2" :masks="masks">
                          <template v-slot="{ inputValue, inputEvents }">
                            <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"/>
                          </template>
                        </DatePicker>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Примечание:</label></td>
                      <td><input class="form-control" :value="change_arr.comment" @input="change_arr.comment=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-else-if="active_tab==2">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Тип:</label></td>
                      <td>
                        <select :class="[{ 'is-invalid': valid_error.change.type },'form-select']" :value="change_arr.type" @change="change_arr.type=$event.target.value;change_arr.brand=0;change_arr.model=0;">
                          <option value="" disabled>Выберите тип</option>
                          <option v-for="item in dict.types_select" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Марка:</label></td>
                      <td>
                        <select class="form-select" :value="change_arr.brand" @change="change_arr.brand=$event.target.value;change_arr.model=0;">
                          <option value="" disabled>Выберите марку</option>
                          <option v-if="change_arr.type!=0" v-for="item in dict.types_select[change_arr.type].brands" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Марка:</label></td>
                      <td>
                        <select class="form-select" :value="change_arr.model" @change="change_arr.model=$event.target.value;">
                          <option value="" disabled>Выберите Модель</option>
                          <option v-if="change_arr.brand!=0 && change_arr.type!=0" v-for="item in dict.types_select[change_arr.type].brands[change_arr.brand].models" :value="item.id">{{item.name}}</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Серийный номер:</label></td>
                      <td><input class="form-control" :value="change_arr.serial_number" @input="change_arr.serial_number=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">IMEI:</label></td>
                      <td><input class="form-control" :value="change_arr.imei" @input="change_arr.imei=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Прошивка:</label></td>
                      <td><input class="form-control" :value="change_arr.firmware" @input="change_arr.firmware=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Конфигурация:</label></td>
                      <td><input class="form-control" :value="change_arr.config" @input="change_arr.config=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Логин:</label></td>
                      <td><input class="form-control" :value="change_arr.login" @input="change_arr.login=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Пароль:</label></td>
                      <td><input class="form-control" :value="change_arr.password" @input="change_arr.password=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-if="active_tab==3">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Сосбветнник:</label></td>
                      <td><input class="form-control" :value="change_arr.sim_owner" @input="change_arr.sim_owner=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Оператор:</label></td>
                      <td><input class="form-control" :value="change_arr.sim_operator" @input="change_arr.sim_operator=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Абонентский номер:</label></td>
                      <td><input class="form-control" :value="change_arr.sim_number" @input="change_arr.sim_number=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">ICCID:</label></td>
                      <td><input class="form-control" :value="change_arr.sim_iccid" @input="change_arr.sim_iccid=$event.target.value;"/></td>
                    </tr>
                    <tr>
                      <td><label class="form-label m-0 left-text">Примечание:</label></td>
                      <td><input class="form-control" :value="change_arr.sim_comment" @input="change_arr.sim_comment=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab" v-if="active_tab==4">
                  <table class="table no-border">
                    <tbody>
                    <tr>
                      <td><label class="form-label m-0 left-text">Место установки:</label></td>
                      <td><input class="form-control" :value="change_arr.installation_location" @input="change_arr.installation_location=$event.target.value;"/></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="open_pop_up.change=false;validate.change=false;">Закрыть</button>
            <button type="button" class="btn btn-success" @click="changeItem();$event.preventDefault();">Сохранить</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import NavTemplate from '@/js/components/Nav.vue'
import { Calendar, DatePicker } from 'v-calendar'
import 'v-calendar/dist/style.css'
import { maska } from 'maska'
import appToast from '@/js/composables/toast-notification'

export default {
  components:{
    NavTemplate,
    Calendar,
    DatePicker,
  },
  setup() {
    const { toastInfo, toastSuccess, toastError, toastWarning } = appToast()
    return {
      toastInfo,
      toastSuccess,
      toastError,
      toastWarning,
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
        owner:"",
        reason_use:"",
        date_sale:null,
        work:"",
        date_work:null,
        comment:"",
        account:"",
        type:"",
        brand:"",
        model:"",
        serial_number:"",
        imei:"",
        firmware:"",
        config:"",
        login:"",
        password:"",
        sim_owner:"",
        sim_operator:"",
        sim_number:"",
        sim_iccid:"",
        sim_comment:"",
        installation_location:"",
      },
      masks:{
        input: 'DD.MM.YYYY',
      },
      change_arr:{
        owner:"",
        reason_use:"",
        date_sale:null,
        work:"",
        date_work:null,
        comment:"",
        account:0,
        type:0,
        brand:0,
        model:0,
        serial_number:"",
        imei:"",
        firmware:"",
        config:"",
        login:"",
        password:"",
        sim_owner:"",
        sim_operator:"",
        sim_number:"",
        sim_iccid:"",
        sim_comment:"",
        installation_location:"",
      },
      dict:{
        types_select:{},
        accounts:{},
        types:{},
        brands:{},
        models:{},
        objects:{},
      },
      validate:{
        add:false,
        change:false,
      },
      valid_error:{
        add:{
          account:false,
          type:false,
        },
        change:{
          account:false,
          type:false,
        }
      },
      active_elem:-1,
      active_tab:1,
    }
  },
  methods:{
    fadeChange(idx){
      this.change_arr = JSON.parse(JSON.stringify(this.arr_data[idx]));
      if(this.change_arr['date_work']) this.change_arr.date_work = this.parseDate(this.change_arr.date_work);
      if(this.change_arr['date_sale']) this.change_arr.date_sale = this.parseDate(this.change_arr.date_sale);
      this.change_arr.index=idx;
      if(this.change_arr.block==0) this.change_arr.block=false; else this.change_arr.block=true;
      this.open_pop_up.change=true;
      this.active_tab=1;
    },
    getData(){
      let fData = new FormData();
      axios.post('/equipment/get',fData)
          .then(response => {
            let data = response.data;
            if(data.result==true){
              for(let i in data['data']){
                let item = data['data'][i];
                for(let i_c in item){
                  if(item[i_c]=="null" || item[i_c]==null) item[i_c]="";
                }
                this.arr_data.push(item);
              }
              for(let i in data['objects']){
                let item = data['objects'][i];
                for(let i_c in item){
                  if(item[i_c]=="null" || item[i_c]==null) item[i_c]="";
                }
                this.dict.objects[item.id]=item;
              }
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
    addItem(){
      let fData = new FormData();
      let current_arr=this.add_arr;
      if(this.isEmpty(current_arr.type) || this.isEmpty(current_arr.account)){
        this.validate.add=true;
        this.checkErrorsAdd();
        this.toastError('Заполните все необходимые поля')
        return;
      }

      fData.append("owner",current_arr.owner);
      fData.append("reason_use",current_arr.reason_use);
      fData.append("date_sale",this.formatDate(current_arr.date_sale));
      fData.append("work",current_arr.work);
      fData.append("date_work",this.formatDate(current_arr.date_work));
      fData.append("comment",current_arr.comment);
      fData.append("account",current_arr.account);
      fData.append("type",current_arr.type);
      fData.append("brand",current_arr.brand);
      fData.append("model",current_arr.model);
      fData.append("serial_number",current_arr.serial_number);
      fData.append("imei",current_arr.imei);
      fData.append("firmware",current_arr.firmware);
      fData.append("config",current_arr.config);
      fData.append("login",current_arr.login);
      fData.append("password",current_arr.password);
      fData.append("sim_owner",current_arr.sim_owner);
      fData.append("sim_operator",current_arr.sim_operator);
      fData.append("sim_number",current_arr.sim_number);
      fData.append("sim_iccid",current_arr.sim_iccid);
      fData.append("sim_comment",current_arr.sim_comment);
      fData.append("installation_location",current_arr.installation_location);

      axios.post('/equipment/add',fData)
          .then(response => {
            let data = response.data;
            if(data.result==true){
              this.arr_data.push(data.data);
              this.toastSuccess('Оборудование создано')
              this.open_pop_up.add=false;
              this.validate.add=false;
              this.add_arr={
                name:"",
                comment:"",
                full_name:"",
                tariff:0,
                pay_method:0,
                limit_debt:"",
                limit_debt_type:0,
                block:false,
                reason_block:"",
                balance:0,
              }
            }
            else{
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
            }
          })
          .catch(error => {
            if (error.response.status === 422) {
              this.toastWarning(error.response.data.message)
            } else {
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
              console.log(error)
            }
          })
          .finally(() => (this.loading = false))
    },
    changeItem(){
      let fData = new FormData();

      let current_arr = this.change_arr;

      if(this.isEmpty(current_arr.type) || this.isEmpty(current_arr.account)){
        this.validate.change=true;
        this.checkErrorsChange();
        this.toastError('Заполните все необходимые поля')
        return;
      }

      fData.append("owner",current_arr.owner);
      fData.append("reason_use",current_arr.reason_use);
      fData.append("date_sale",this.formatDate(current_arr.date_sale));
      fData.append("work",current_arr.work);
      fData.append("date_work",this.formatDate(current_arr.date_work));
      fData.append("comment",current_arr.comment);
      fData.append("account",current_arr.account);
      fData.append("type",current_arr.type);
      fData.append("brand",current_arr.brand);
      fData.append("model",current_arr.model);
      fData.append("serial_number",current_arr.serial_number);
      fData.append("imei",current_arr.imei);
      fData.append("firmware",current_arr.firmware);
      fData.append("config",current_arr.config);
      fData.append("login",current_arr.login);
      fData.append("password",current_arr.password);
      fData.append("sim_owner",current_arr.sim_owner);
      fData.append("sim_operator",current_arr.sim_operator);
      fData.append("sim_number",current_arr.sim_number);
      fData.append("sim_iccid",current_arr.sim_iccid);
      fData.append("sim_comment",current_arr.sim_comment);
      fData.append("installation_location",current_arr.installation_location);
      fData.append("id",current_arr.id);

      axios.post('/equipment/change',fData)
          .then(response => {
            let data = response.data;
            if(data.result==true){
              this.toastSuccess('Оборудование изменено')
              data.data.date_sale=this.parseDate(data.data.date_sale);
              data.data.date_work=this.parseDate(data.data.date_work);
              this.arr_data[this.change_arr.index]=data.data;
            }
            else{
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
            }
          })
          .catch(error => {
            if (error.response.status === 422) {
              this.toastWarning(error.response.data.message)
            } else {
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
              console.log(error)
            }
          })
          .finally(() => (this.loading = false));
    },
    deleteItem(){
      if(!confirm("Вы действительно хотите удалить оборудование?")) return false;

      let fData = new FormData();
      fData.append("id",this.arr_data[this.active_elem].id);

      axios.post('/equipment/delete',fData)
          .then(response => {
            let data = response.data;
            if(data.result==true){
              this.toastSuccess('Оборудование удалено')
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

      axios.post('/equipment/init',fData)
          .then(response => {
            let data = response.data;
            if(data.result==true){
              this.dict.brands=data.brands;
              this.dict.types_select=data.all;
              this.dict.models=data.models;
              this.dict.types=data.types;
              this.dict.accounts=data.accounts;
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
    parseNull(data){
      for(let i_c in data){
        if(data[i_c]=="null" || data[i_c]==null) data[i_c]="";
      }
      return data;
    },
    returnValueOrNull(data,item){
      if(typeof data[item] != "undefined") return data[item].name;
      return "";
    },
    isEmpty(str){
      if(typeof str == "undefined") return true;
      if(this.isAN(str)) return false;
      if(!str || str==null) return false;
      if(str.length==0 || str=="" || str.trim()=="") return true;
      return false;
    },
    isAN(value) {
      return (value instanceof Number||typeof value === 'number') && !isNaN(value);
    },
    blockTextReturn(block){
      if(block==1) return "Заблокирован";
      else return "Активен";
    },
    parseDate(dates){
      try{
        let data = new Date(dates);
        let returned_date = new Date(data.getFullYear(),data.getMonth(),data.getDate());
        return returned_date;
      }catch (e){
        return "";
      }
    },
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
    formatDate(date){
      if(!date || date=="" || typeof date == "undefined") return "";

      let year = date.toLocaleString("default", { year: "numeric" });
      let month = date.toLocaleString("default", { month: "2-digit" });
      let day = date.toLocaleString("default", { day: "2-digit" });

      let formattedDate = year + "-" + month + "-" + day;
      return formattedDate;
    }
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
  directives: { maska },
  mounted() {
    this.init();
  }
}
</script>
