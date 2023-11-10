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
        <div class="click-btn d-flex justify-content-center align-items-center delete-btn" @click="deleteItem();">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315"><g><path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"></path><path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"></path><path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"></path><path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"></path></g></svg>
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

  <tariffs-table
    :data="arr_data"
    @row-click="rowClick"
    @row-double-click="rowDoubleClick"
  ></tariffs-table>

  <transition name="fade">
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="open_pop_up.add">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Добавление тарифа</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.add=false"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <table class="table no-border">
                <tbody>
                <tr>
                  <td><label class="form-label m-0 left-text">Наименование:</label></td>
                  <td><input :class="[{ 'is-invalid': valid_error.add.name },'form-control']" :value="add_arr.name" @input="add_arr.name=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text">Коментарий:</label></td>
                  <td><input class="form-control" :value="add_arr.comment" @input="add_arr.comment=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Длина истории сообщений:</label></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <select class="form-select" :value="add_arr.long_type" @change="add_arr.long_type=$event.target.value;">
                        <option selected value="0">Не ограничена</option>
                        <option value="1">Пользовательский</option>
                      </select>
                      <div class="item flex-grow-1 ms-2 d-flex align-items-center">
                        <label class="form-label text-nowrap mb-0 me-2">В часах</label>
                        <input type="text" class="form-control" :disabled="add_arr.long_type==0" :value="add_arr.long_time" @input="add_arr.long_time=$event.target.value;">
                      </div>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Тариф абонента</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='add_arr.abon_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.add_arr.abon_tariff,this.custom_active.abon_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in add_arr.abon_tariff" @click="custom_active.abon_tariff=idx" v-bind:class="[{ 'active': custom_active.abon_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Ежемесячные услуги</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='add_arr.every_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.add_arr.every_tariff,this.custom_active.every_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in add_arr.every_tariff" @click="custom_active.every_tariff=idx" v-bind:class="[{ 'active': custom_active.every_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Единовлеменные услуги</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='add_arr.one_time_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.add_arr.one_time_tariff,this.custom_active.one_time_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in add_arr.one_time_tariff" @click="custom_active.one_time_tariff=idx" v-bind:class="[{ 'active': custom_active.one_time_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Железо</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='add_arr.metal.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.add_arr.metal,this.custom_active.metal);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in add_arr.metal" @click="custom_active.metal=idx" v-bind:class="[{ 'active': custom_active.metal==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="open_pop_up.add=false">Закрыть</button>
            <button type="button" class="btn btn-success" @click="addItem();$event.preventDefault();">Добавить</button>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <transition name="fade">
    <div class="modal fade show" tabindex="-1" aria-hidden="true" v-if="open_pop_up.change">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Изменение тарифа</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="open_pop_up.change=false"></button>
          </div>
          <div class="modal-body">
            <form class="normal-form">
              <table class="table no-border">
                <tbody>
                <tr>
                  <td><label class="form-label m-0 left-text">Наименование:</label></td>
                  <td><input :class="[{ 'is-invalid': valid_error.change.name },'form-control']" :value="change_arr.name" @input="change_arr.name=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label m-0 left-text">Коментарий:</label></td>
                  <td><input class="form-control" :value="change_arr.comment" @input="change_arr.comment=$event.target.value;"/></td>
                </tr>
                <tr>
                  <td><label class="form-label left-text">Длина истории сообщений:</label></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <select class="form-select" :value="change_arr.long_type" @change="change_arr.long_type=$event.target.value;">
                        <option selected value="0">Не ограничена</option>
                        <option value="1">Пользовательский</option>
                      </select>
                      <div class="item flex-grow-1 ms-2 d-flex align-items-center">
                        <label class="form-label text-nowrap mb-0 me-2">В часах</label>
                        <input type="text" class="form-control" :disabled="change_arr.long_type==0" :value="change_arr.long_time" @input="change_arr.long_time=$event.target.value;">
                      </div>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Тариф абонента</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='change_arr.abon_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.change_arr.abon_tariff,this.custom_active.abon_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in change_arr.abon_tariff" @click="custom_active.abon_tariff=idx" v-bind:class="[{ 'active': custom_active.abon_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Ежемесячные услуги</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='change_arr.every_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.change_arr.every_tariff,this.custom_active.every_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in change_arr.every_tariff" @click="custom_active.every_tariff=idx" v-bind:class="[{ 'active': custom_active.every_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Единовлеменные услуги</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='change_arr.one_time_tariff.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.change_arr.one_time_tariff,this.custom_active.one_time_tariff);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in change_arr.one_time_tariff" @click="custom_active.one_time_tariff=idx" v-bind:class="[{ 'active': custom_active.one_time_tariff==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="form-list-item d-flex flex-column align-items-start mb-3">
                <label class="form-label">Железо</label>
                <div class="flex-buttons d-flex gap-3 align-items-center">
                  <div class="add-button button d-flex align-items-center" @click='change_arr.metal.push({name:"",price:"",category:""})'>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 490 490" style="enable-background:new 0 0 490 490;" xml:space="preserve">
                    <polygon points="222.031,490 267.969,490 267.969,267.969 490,267.969 490,222.031 267.969,222.031 267.969,0 222.031,0
                      222.031,222.031 0,222.031 0,267.969 222.031,267.969 "/>
                    </svg>
                    <span>Добавить</span>
                  </div>
                  <div class="delete-button button d-flex align-items-center" @click="deleteSmallItem(this.change_arr.metal,this.custom_active.metal);">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 315" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 315 315">
                      <g>
                        <path d="m256.774,23.942h-64.836v-6.465c0-9.636-7.744-17.477-17.263-17.477h-34.348c-9.521,0-17.266,7.841-17.266,17.478v6.465h-64.835c-9.619,0-17.445,7.76-17.445,17.297v11.429c0,7.168 4.42,13.33 10.698,15.951 1.989,39.623 13.5,231.193 14.018,239.801 0.222,3.696 3.284,6.58 6.987,6.58h170.033c3.703,0 6.766-2.884 6.987-6.58 0.518-8.607 12.028-200.178 14.018-239.801 6.278-2.621 10.698-8.783 10.698-15.951v-11.43c5.68434e-14-9.537-7.826-17.297-17.446-17.297zm-119.713-6.464c0-1.918 1.465-3.478 3.266-3.478h34.348c1.8,0 3.264,1.56 3.264,3.478v6.465h-40.877v-6.465zm-82.282,23.761c0-1.818 1.546-3.297 3.445-3.297h198.549c1.899,0 3.445,1.478 3.445,3.297v11.429c0,1.819-1.546,3.299-3.445,3.299h-198.548c-1.899,0-3.445-1.479-3.445-3.299v-11.429zm181.143,259.761h-156.848c-2.055-34.247-11.479-191.674-13.51-231.033h183.867c-2.031,39.359-11.454,196.786-13.509,231.033z"/>
                        <path d="m157.5,95.125c-3.866,0-7,3.134-7,7v176.109c0,3.866 3.134,7 7,7 3.866,0 7-3.134 7-7v-176.109c0-3.866-3.134-7-7-7z"/>
                        <path d="m110.2,102.04c-0.202-3.86-3.507-6.837-7.355-6.625-3.86,0.201-6.827,3.494-6.625,7.355l9.182,175.829c0.195,3.736 3.285,6.635 6.984,6.635 0.123,0 0.247-0.003 0.371-0.01 3.86-0.201 6.827-3.494 6.625-7.355l-9.182-175.829z"/>
                        <path d="m212.155,95.415c-3.899-0.223-7.153,2.764-7.355,6.625l-9.184,175.829c-0.202,3.861 2.765,7.154 6.625,7.355 0.125,0.007 0.248,0.01 0.371,0.01 3.698,0 6.789-2.898 6.984-6.635l9.184-175.829c0.202-3.861-2.764-7.154-6.625-7.355z"/>
                      </g>
                    </svg>
                    <span>Удалить</span>
                  </div>
                </div>
                <div class="form-table w-100">
                  <table class="table">
                    <thead>
                    <tr>
                      <th scope="col">Название</th>
                      <th scope="col">Стоимость</th>
                      <th scope="col">Категория</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,idx) in change_arr.metal" @click="custom_active.metal=idx" v-bind:class="[{ 'active': custom_active.metal==idx }]">
                      <th scope="col"><input type="text" :value="item.name" @input="item.name=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.price" @input="item.price=$event.target.value;"></th>
                      <th scope="col"><input type="text" :value="item.category" @input="item.category=$event.target.value;"></th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="open_pop_up.change=false">Закрыть</button>
            <button type="button" class="btn btn-success" @click="changeItem();$event.preventDefault();">Изменить</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import NavTemplate from '@/js/components/Nav.vue'
import appToast from '@/js/composables/toast-notification'
import TariffsTable from '@/js/views/panel/tariffs/TariffsTable.vue'

export default {
  name: 'Tariffs',
  components: {
    TariffsTable, NavTemplate
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
      add_arr:{
        name:"",
        comment:"",
        long_type:0,
        long_time:0,
        abon_tariff:[],
        every_tariff:[],
        one_time_tariff:[],
        metal:[],
      },
      change_arr:{
        name:"",
        comment:"",
        long_type:0,
        long_time:0,
        abon_tariff:[],
        every_tariff:[],
        one_time_tariff:[],
        metal:[],
        id:0,
        idx:0
      },
      arr_data:[

      ],
      custom_active:{
        abon_tariff:-1,
        every_tariff:-1,
        one_time_tariff:-1,
        metal:-1,
      },
      active_elem:-1,
      search: null,
      open_pop_up:{
        add:false,
        change:false,
      },
      validate:{
        add:false,
        change:false,
      },
      valid_error:{
        add:{
          name:false,
        },
        change:{
          name:false,
        },
      },
    }
  },
  methods:{
    deleteSmallItem(arr,elem){
      if(elem>=0) arr.splice(elem,1);
    },
    addItem(){

      let current_arr=this.add_arr;
      if(this.isEmpty(current_arr.name)){
        this.validate.add=true;
        this.checkErrorsAdd();
        return;
      }

      let fData = new FormData();
      fData.append("id", current_arr.id);
      fData.append("name",current_arr.name);
      fData.append("comment",current_arr.comment);
      if(current_arr.long_type==0) fData.append("history_duration",-1); else fData.append("history_duration",current_arr.long_time);
      fData.append("abon_tariff",JSON.stringify(current_arr.abon_tariff));
      fData.append("every_tariff",JSON.stringify(current_arr.every_tariff));
      fData.append("one_time_tariff",JSON.stringify(current_arr.one_time_tariff));
      fData.append("metal",JSON.stringify(current_arr.metal));

      axios.post('/tariff/add',fData)
          .then(response => {
            let data = response.data;
            if(data.result){
              this.toastSuccess('Тариф добавлен')
              let item = data.data;
              if(item.history_duration==-1){ item.long_time=0; item.long_type=0}
              else{ item.long_time=item.history_duration; item.long_type=1};
              item.abon_tariff=JSON.parse(item.abon_tariff);
              item.every_tariff=JSON.parse(item.every_tariff);
              item.one_time_tariff=JSON.parse(item.one_time_tariff);
              item.metal=JSON.parse(item.metal);
              this.arr_data.push(item);
              this.open_pop_up.add=false;
            }
            else{
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
            }
          })
          .catch(() => this.toastWarning('Что-то пошло не так. Попробуйте позже'))
          .finally(() => (this.loading = false));
    },
    changeItem(){

      let current_arr=this.change_arr;
      if(this.isEmpty(current_arr.name)){
        this.validate.change=true;
        this.checkErrorsChange();
        return;
      }

      let fData = new FormData();
      fData.append("name",current_arr.name);
      fData.append("comment",current_arr.comment);
      if(current_arr.long_type==0) fData.append("history_duration",-1); else fData.append("history_duration",current_arr.long_time);
      fData.append("abon_tariff",JSON.stringify(current_arr.abon_tariff));
      fData.append("every_tariff",JSON.stringify(current_arr.every_tariff));
      fData.append("one_time_tariff",JSON.stringify(current_arr.one_time_tariff));
      fData.append("metal",JSON.stringify(current_arr.metal));
      fData.append("id",JSON.stringify(current_arr.id));

      axios.post('/tariff/change',fData)
          .then(response => {
            let data = response.data;
            if(data.result){
              this.arr_data[this.change_arr.index]=data.data;
              this.toastSuccess('Тариф изменён');
              console.log(response)
            }
            else{
              this.toastWarning('Что-то пошло не так. Попробуйте позже')
            }
          })
          .catch(error => {
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          })
          .finally(() => (this.loading = false));
    },
    fadeChange(idx){
      this.change_arr = JSON.parse(JSON.stringify(this.arr_data[idx]));
      this.change_arr.index=idx;
      if(this.change_arr.block==0) this.change_arr.block=false; else this.change_arr.block=true;
      this.open_pop_up.change=true;
    },
    getData(){
      let fData = new FormData();

      if (this.search) {
        fData.append('search', this.search)
      }

      axios.post('/tariff/get',fData)
          .then(response => {
            let data = response.data;
            if(data.result){
              this.arr_data = []
              for(let i in data.data){
                let item = data['data'][i];
                for(let i_c in item){
                  if(item[i_c]=="null" || item[i_c]==null) item[i_c]="";
                }
                if(item.history_duration==-1){ item.long_time=0; item.long_type=0}
                else{ item.long_time=item.history_duration; item.long_type=1};
                item.abon_tariff=JSON.parse(item.abon_tariff);
                item.every_tariff=JSON.parse(item.every_tariff);
                item.one_time_tariff=JSON.parse(item.one_time_tariff);
                item.metal=JSON.parse(item.metal);
                this.arr_data.push(item);
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
    deleteItem(){

      if(!confirm("Вы действительно хотите удалить Тариф?")){
        return false;
      }

      if(!this.arr_data[this.active_elem]){
        this.toastWarning('Что-то пошло не так. Попробуйте ещё раз')
      }

      let fData = new FormData();
      fData.append("id", this.arr_data[this.active_elem].id);

      axios.post('/tariff/delete',fData)
          .then(response => {
            let data = response.data;
            if(data.result){
              this.arr_data.splice(this.active_elem,1);
              this.toastSuccess('Тариф удалён')
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
    ResetAllValues(){
      this.custom_active.metal=-1;
      this.custom_active.one_time_tariff=-1;
      this.custom_active.every_tariff=-1;
      this.custom_active.abon_tariff=-1;
    },
    rowClick(active) {
      this.active_elem = active
    },
    rowDoubleClick: function(idx){
      this.fadeChange(idx);
      this.ResetAllValues()
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
      if(!str) return true;
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
    returnValueOrNull(data,item,child="",child2=""){
      if(!data) return "";
      if(child2!="" && child!=""){
        if(typeof item[child] == "undefined") return "";
        if(typeof item[child][child2] == "undefined") return "";
        let i = item[child][child2];
        if(typeof data[i] == "undefined") return "";
        if(typeof data[i].name == "undefined") return "";
        return data[i].name;
      }
      else if(child!=""){
        if(typeof data == "undefined" || typeof item == "undefined" || typeof data[item] == "undefined") return "";
        if(data[item][child]) return data[item][child];
      }
      else{
        if(typeof data[item] != "undefined") return data[item].name;
      }

      return "";
    },
    blockTextReturn(block){
      if(block==1) return "Заблокирован";
      else return "Активен";
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
    checkArrayItem(arr,elem){
      for(let i in arr){
        let item = arr[i];
        if(item==elem){
          return true;
          break;
        }
      }
      return false;
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
  mounted() {
    this.getData();
  }
}
</script>
<style>
.modal{
  display: block;
  background: rgba(0,0,0,0.5);
}
.modal .modal-dialog{
  max-width: 900px;
}
table.main-table tr{
  cursor: pointer;
}
.form-list-item .flex-buttons{

}
.form-list-item .flex-buttons .button svg{
  height: 25px;
  fill: white;
  margin-right: 10px;
  transition: 0.3s;
}
.form-list-item .flex-buttons .button{
  border: 2px solid #4BB543;
  background: #4BB543;
  padding: 8px 15px;
  border-radius: 255px;
  color: white;
  font-size: 16px;
  cursor: pointer;
  transition: 0.3s;
}
.form-list-item .flex-buttons .button.delete-button{
  background: #F20000;
  border: 2px solid #F20000;
}
.form-list-item .flex-buttons .button:hover{
  background: none;
  color: black;
}
.form-list-item .flex-buttons .button:hover svg{
  fill: black;
}
.form-list-item input{
  border: none;
  outline: none;
  text-align: center;
  width: 100%;
  background: none;
}
.form-list-item table tr.active{
  background: rgba(0,0,0,0.1);
}
.main-table .active-parent{
  background: rgba(13, 110, 253,0.3);
}
</style>
