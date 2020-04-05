const elToggleAvatars = document.querySelectorAll('[data-toggle="avatar-uploader"]')

elToggleAvatars.forEach(elToggleAvatar => {
  const elTarget = document.querySelector(elToggleAvatar.getAttribute('data-target'))
  if(elTarget) {
    elTarget.addEventListener('change', () => {
      filename = elTarget.value.match(/[^\\/]*$/)[0]
      elTarget.parentElement.querySelector('p').innerText = filename
    })
  }
  elToggleAvatar.addEventListener('click', (ev) => {
    ev.preventDefault()
    elTarget.click()
  })
})

