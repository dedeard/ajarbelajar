window.initAutocomplete = (target = 'autoComplete', src = [], key = '') => {
  return new autoComplete({
    data: {
      src,
      key,
    },
    sort: (a, b) => {
      if (a.match < b.match) return -1
      if (a.match > b.match) return 1
      return 0
    },
    selector: '#' + target,
    threshold: 0,
    debounce: 0,
    searchEngine: 'strict',
    highlight: true,
    maxResults: 5,
    resultsList: {
      render: true,
      destination: document.getElementById(target),
      position: 'afterend',
      element: 'ul',
    },
    resultItem: {
      content: (data, source) => {
        source.innerHTML = data.match
      },
      element: 'li',
    },
    onSelection: (feedback) => {
      const selection = feedback.selection.value.name
      $('#' + target).val(selection)
      setTimeout(() => {
        $('#' + target).focus()
      }, 50)
    },
  })
}
