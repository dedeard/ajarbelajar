/** @type {import('alpinejs').Alpine} */
const Alpine = window.Alpine

const commandMap = {
  undo: {
    start: '',
    end: '',
    defaultText: '',
    shortcut: 'KeyZ',
  },
  redo: {
    start: '',
    end: '',
    defaultText: '',
    shortcut: 'KeyY',
  },
  strong: {
    start: '**',
    end: '**',
    defaultText: 'strong text',
    shortcut: 'KeyB',
  },
  italic: {
    start: '*',
    end: '*',
    defaultText: 'emphasized text',
    shortcut: 'KeyI',
  },
  unorderedList: {
    start: '\n- ',
    end: '\n',
    defaultText: 'list item',
    shortcut: 'ShiftLeft+KeyU',
  },
  orderedList: {
    start: '\n1. ',
    end: '\n',
    defaultText: 'list item',
    shortcut: 'ShiftLeft+KeyO',
  },
  link: {
    start: '[',
    end: '](url)',
    defaultText: 'linked text',
    shortcut: 'KeyK',
  },
}

Alpine.data('markdown', () => ({
  preview: false,
  history: [],
  position: -1,
  textarea: null,
  commandMap,

  init() {
    this.textarea = this.$refs.textarea
    this.textarea.addEventListener('keydown', this.handleKeyDown.bind(this))
    this.textarea.addEventListener('input', this.makeHistory.bind(this))
  },

  handleKeyDown(e) {
    const shortcuts = Object.keys(this.commandMap)
      .filter((key) => this.commandMap[key].shortcut)
      .reduce((acc, key) => {
        const { shortcut } = this.commandMap[key]
        acc[shortcut] = key
        return acc
      }, {})

    const shortcut = (e.shiftKey ? 'ShiftLeft+' : '') + e.code
    const command = shortcuts[shortcut]

    if (e.ctrlKey && command) {
      e.preventDefault()
      this.formatText.bind(this)(command)
    }
  },

  makeHistory() {
    this.position++
    this.history.splice(this.position)
    const { value, selectionStart, selectionEnd } = this.textarea
    this.history.push({ value, selectionStart, selectionEnd })
  },

  setSelection(start, end) {
    if (this.textarea.setSelectionRange) {
      this.textarea.setSelectionRange(start, end)
    } else if (this.textarea.createTextRange) {
      const range = this.textarea.createTextRange()
      range.collapse(true)
      range.moveEnd('character', start)
      range.moveStart('character', end)
      range.select()
    }
    this.textarea.focus()
  },

  formatText(command) {
    const { value, selectionStart, selectionEnd } = this.textarea
    let startText = value.slice(0, selectionStart)
    let endText = value.slice(selectionEnd)
    let selectedText = value.substring(selectionStart, selectionEnd)

    if (command === 'undo') {
      if (this.position > 0) {
        this.position--
        const { value, selectionStart, selectionEnd } = this.history[this.position]
        this.textarea.value = value
        this.setSelection(selectionStart, selectionEnd)
      } else if (this.position === 0) {
        this.textarea.value = ''
        this.position = -1
        this.setSelection(0, 0)
      }
    } else if (command === 'redo') {
      if (this.position < this.history.length - 1) {
        this.position++
        const { value, selectionStart, selectionEnd } = this.history[this.position]
        this.textarea.value = value
        this.setSelection(selectionStart, selectionEnd)
      }
    } else {
      const { start, end, defaultText } = this.commandMap[command]
      selectedText = selectedText || defaultText || ''
      this.textarea.value = startText + start + selectedText + end + endText
      this.setSelection(selectionStart + start.length, selectionStart + start.length + selectedText.length)
      this.textarea.dispatchEvent(new Event('input'))
    }
  },
}))
