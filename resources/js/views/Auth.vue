<template>
  <div class="flex-auth-container d-flex justify-content-center align-items-center">
    <div class="auth-form-container">
      <img src="@/img/logo.png" alt="" class="logo">
      <transition name="fade" mode="out-in">
        <div class="fade-div" v-if="auth_fade==0">
          <div class="title">Вход в аккаунт</div>
          <form action="" class="login-form auth-form" @submit="$event.preventDefault();sendAuth();">
            <div class="mb-3">
              <input
                type="text"
                class="form-control"
                placeholder="Имя"
                @input="auth.login = $event.target.value"
                :value="auth.login"
              >
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" placeholder="Пароль" @input="auth.password=$event.target.value" :value="auth.password">
            </div>
            <button class="btn btn-primary full">Вход</button>
          </form>
          <div class="small-form-text">Ещё нет аккаунта? <a href="#" @click="$event.preventDefault();auth_fade=1;">Регистрация</a></div>
<!--          <div class="small-form-text">Забыли пароль? <a href="#" @click="$event.preventDefault();auth_fade=2;">Восстановить</a></div>-->
        </div>
        <div class="fade-div" v-else>
          <div class="title">Регистрация</div>
          <form action="" class="login-form auth-form" @submit="$event.preventDefault();sendReg();">
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" @input="reg.email=$event.target.value" :value="reg.email">
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Логин" @input="reg.login=$event.target.value" :value="reg.login">
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" placeholder="Имя" @input="reg.name=$event.target.value" :value="reg.name">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" placeholder="Пароль" @input="reg.password=$event.target.value" :value="reg.password">
            </div>
            <button class="btn btn-primary full">Регистрация</button>
          </form>
          <div class="small-form-text">Уже есть аккаунт? <a href="#" @click="$event.preventDefault();auth_fade=0;">Вход</a></div>
        </div>
<!--        <div class="fade-div" v-else>
          <div class="title">Восстановление пароля</div>
          <form action="" class="login-form auth-form" @submit="$event.preventDefault();sendForgot;">
            <div class="mb-3">
              <input type="email" class="form-control" placeholder="Email" @input="forgot.email=$event.target.value" :value="forgot.email">
            </div>
            <button class="btn btn-primary full">Восстановить</button>
          </form>
          <div class="small-form-text">Вспомнили пароль? <a href="#" @click="$event.preventDefault();auth_fade=0;">Обратно</a></div>
        </div>-->
      </transition>
    </div>
  </div>
</template>
<script>
import appToast from '@/js/composables/toast-notification'

export default {
  name: 'Auth',
  data(){
    return{
      auth:{
        login:"",
        password:"",
      },
      reg:{
        login:"",
        email:"",
        name:"",
        password:"",
      },
      forgot:{
        email:""
      },
      auth_fade:0
    }
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
  methods:{
    sendReg(){
      if(this.isEmpty(this.reg.name) || this.isEmpty(this.reg.email) || this.isEmpty(this.reg.login) || this.isEmpty(this.reg.password)){
        this.toastWarning('Заполните все поля')
        return false;
      }

      if(this.reg.password.length<6){
        this.toastError('Пароль должен состоять из 6 или более символов')
        return false;
      }

      let fData = new FormData();
      fData.append("name",this.reg.name);
      fData.append("email",this.reg.email);
      fData.append("login",this.reg.login);
      fData.append("password",this.reg.password);
      fData.append("device_name","browser");

      axios
          .post('/auth/reg',fData)
          .then(response => {
            let data = response.data;
            if(data.result){
              this.toastInfo('На указанный email было отправлено письмо для подтверждения регистрации')
              window.localStorage.setItem("auth_token",data.token);
              this.$router.push({name: 'panel'});
            }
            else{
              if(data.code=="exist_email"){
                this.toastError('Такой email уже зарегистрирован')
              }
              else if(data.code=="exist_login"){
                this.toastError('Такой логин уже зарегистрирован')
              }
              else{
                this.toastWarning('Что-то пошло не так. Попробуйте позже')
              }
            }
          })
          .catch(error => {
            this.toastWarning('Что-то пошло не так. Попробуйте позже')
          })
          .finally(() => (this.loading = false));
    },
    sendAuth(){

      if(this.isEmpty(this.auth.login) || this.isEmpty(this.auth.password)){
        this.toastError('Заполните все поля')
        return false;
      }

      if(this.auth.password.length<6){
        this.toastError('Пароль должен состоять из 6 или более символов')
        return false;
      }


      let fData = new FormData();
      fData.append("login",this.auth.login);
      fData.append("password",this.auth.password);
      fData.append("device_name","browser");

       axios.post('/auth/login', fData)
          .then(response => this.processAuthResult(response))
          .catch(() => this.toastWarning('Что-то пошло не так. Попробуйте позже'))
          .finally(() => this.loading = false)
    },
    processAuthResult(response) {
      let data = response.data
      if (data.result) {
        this.processSuccessAuth(data)
      } else {
        this.processErrorAuth(data)
      }
    },
    processSuccessAuth(data) {
      this.toastSuccess('Вы успешно вошли в аккаунт')
      window.localStorage.setItem('auth_token', data.token)
      if (data.user) {
        window.localStorage.setItem('user', JSON.stringify(data.user))
        const routeName = data.user.role_id === 3 ? 'user-objects' : 'accounts'
        this.$router.push({name: routeName})
      }
    },
    processErrorAuth(data) {
      const toastOptions = {position: 'top-center', toastClassName: 'center-position'}
      if (data.code === 'error_data') {
        this.toastError('Неверный логин или пароль', toastOptions)
      } else {
        const text = data.code === 'blocked' ? data.message : 'Что-то пошло не так. Попробуйте позже'
        this.toastWarning(text, toastOptions)
      }
    },
    isEmpty(str){
      if(!str || str.length==0 || str=="" || str.trim()=="") return true;
      return false;
    }
  }
}
</script>
