/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine
/** @type {import('tailwindcss/colors')} */
const tcolors = window.tcolors

const colors = {
  primary: tcolors.indigo[600],
  success: tcolors.green[600],
  danger: tcolors.red[600],
  warning: tcolors.yellow[600],
  grays: tcolors.gray,
}

const toastOptions = {
  progressBarColor: colors.primary,
  theme: 'light',
  color: colors.grays[200],
  titleColor: colors.grays[700],
  titleSize: '16px',
  messageColor: colors.grays[500],
  messageSize: '14px',
  icon: 'ft-bell',
  message: 'Hello World!',
  iconColor: colors.primary,
  position: 'topRight',
  transitionIn: 'fadeInLeft',
  transitionInMobile: 'fadeInDown',
  transitionOut: 'fadeOutRight',
  transitionOutMobile: 'fadeOutUp',
  zindex: 99999,
}

window.toast = {
  show(message = 'Welcome!', customOptions = {}) {
    iziToast.show({ ...toastOptions, message, ...customOptions })
  },
  success(message = 'Success', customOptions = {}) {
    iziToast.success({
      ...toastOptions,
      iconColor: colors.primary,
      progressBarColor: colors.primary,
      icon: 'ft-check-circle',
      title: 'Success',
      message,
      ...customOptions,
    })
  },
  warning(message = 'Warning', customOptions = {}) {
    iziToast.warning({
      ...toastOptions,
      iconColor: colors.warning,
      progressBarColor: colors.warning,
      icon: 'ft-alert-triangle',
      title: 'Warning',
      message,
      ...customOptions,
    })
  },
  danger(message = 'Tampaknya ada yang salah', customOptions = {}) {
    iziToast.error({
      ...toastOptions,
      iconColor: colors.danger,
      progressBarColor: colors.danger,
      icon: 'ft-x-circle',
      title: 'Error',
      message,
      ...customOptions,
    })
  },
}

Alpine.store('toast', window.toast)
