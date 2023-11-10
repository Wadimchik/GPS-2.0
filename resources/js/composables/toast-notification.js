import { useToast } from 'vue-toastification'

export default function appToast() {
  const toast = useToast()
  const toastInfo = (text, options = {}) => toast.info(text, options)
  const toastSuccess = (text, options = {}) => toast.success(text, options)
  const toastWarning = (text, options = {}) => toast.warning(text, options)
  const toastError = (text, options = {}) => toast.error(text, options)
  return {
    toastInfo,
    toastSuccess,
    toastWarning,
    toastError,
  }
}
