import router from '@/js/router'
import appToast from '@/js/composables/toast-notification'

export default function authManager() {

  const { toastSuccess } = appToast()

  const logout = () => {
    window.localStorage.removeItem('auth_token')
    window.localStorage.removeItem('user')
    toastSuccess('Вы успешно вышли из аккаунта')
    router.push({name: 'auth'})
  }

  return {
    logout
  }
}
