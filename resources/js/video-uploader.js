import FormData from 'form-data'

window.onload = function(){
  const input = $('#video-input')
  const uploadMessage =  $('#video-upload-message')
  const uploadUrl = input.attr('upload-url')

  input.on('change', function(){
    if(!input.prop('files')) return;

    const file = input.prop('files')[0];
    const data = new FormData
    data.append('file', file);

    const config = {
      onUploadProgress: progressEvent => {
        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
        if(percentCompleted === 100){
          uploadMessage.html('Video anda sedang diproses...');
        } else {
          uploadMessage.html('Sedang mengupload ' + file.name + ' total ' + percentCompleted + '%');
        }
      }
    }
    input.attr('disabled', true)
    axios.post(uploadUrl, data, config)
    .then(function(res) {
      window.location.reload(true)
    }).catch(err => {
      input.attr('disabled', false)
      if(err.response && err.response.data && err.response.data.message) {
        uploadMessage.html(err.response.data.message)
      }else {
        uploadMessage.html("Gagal mengupload file!");
      }
    })
  })
}