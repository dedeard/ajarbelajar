const commandMap = {
  undo: {
    start: '',
    end: '',
    defaultText: '',
    shortcut: 'KeyZ',
    icon: 'ft ft-corner-up-left',
    label: 'Undo (Ctrl+Z)',
  },
  redo: {
    start: '',
    end: '',
    defaultText: '',
    shortcut: 'KeyY',
    icon: 'ft ft-corner-up-right',
    label: 'Redo (Ctrl+Y)',
  },
  // heading: {
  //   start: '\n## ',
  //   end: '\n',
  //   defaultText: 'Heading',
  //   shortcut: '',
  //   icon: 'ft ft-type',
  //   label: 'Heading',
  // },
  strong: {
    start: '**',
    end: '**',
    defaultText: 'strong text',
    shortcut: 'KeyB',
    icon: 'ft ft-bold',
    label: 'Bold (Ctrl+B)',
  },
  italic: {
    start: '*',
    end: '*',
    defaultText: 'emphasized text',
    shortcut: 'KeyI',
    icon: 'ft ft-italic',
    label: 'Italic (Ctrl+I)',
  },
  list: {
    start: '\n- ',
    end: '\n',
    defaultText: 'list item',
    shortcut: 'ShiftLeft+KeyU',
    icon: 'ft ft-list',
    label: 'Unordered List (Ctrl+Shift+U)',
  },
  link: {
    start: '[',
    end: '](url)',
    defaultText: 'linked text',
    shortcut: 'KeyK',
    icon: 'ft ft-link',
    label: 'Unordered List (Ctrl+Shift+U)',
  },
  quote: {
    start: '\n> ',
    end: '\n',
    defaultText: 'quoted text',
    shortcut: '',
    icon: 'ft ft-chevrons-right',
    label: 'Blockquote',
  },
  code: {
    start: '`',
    end: '`',
    defaultText: 'code text',
    shortcut: '',
    icon: 'ft ft-code',
    label: 'Inline Code',
  },
  codeBlock: {
    start: '\n```php\n',
    end: '\n```\n',
    defaultText: '<?php\n\necho "Hello World!"',
    shortcut: '',
    icon: 'ft ft-hash',
    label: 'Block Code',
  },
  image: {
    start: '![',
    end: '](image-url)',
    defaultText: 'alt text',
    shortcut: '',
    icon: 'ft ft-image',
    label: 'Image',
  },
  table: {
    start: '\n| ',
    end: ' | Column 2 | Column 3 |\n|---------|---------|---------|\n| Cell 1  | Cell 2  | Cell 3  |\n',
    defaultText: 'Column 1',
    shortcut: '',
    icon: 'ft ft-grid',
    label: 'Table',
  },
  horizontalRule: {
    start: '\n\n---',
    end: '\n\n',
    defaultText: '',
    shortcut: '',
    icon: 'ft ft-minus',
    label: 'Horizontal Rule',
  },
}

document.addEventListener('alpine:init', () => {
  Alpine.data('markdown', () => ({
    preview: false,
    history: [],
    position: -1,
    lines: [],
    activeLine: '',
    activeLineNumber: -1,
    textarea: null,
    commandMap,

    init() {
      this.textarea = this.$refs.textarea
      this.textarea.addEventListener('keydown', this.handleKeyDown.bind(this))
      this.textarea.addEventListener('input', this.handleInput.bind(this))

      this.refreshLine()
      const eventListeners = [
        'select',
        'keyup',
        'keypress',
        'click',
        'mousemove',
        'mousedown',
        'mouseup',
        'mouseleave',
      ]
      eventListeners.forEach((eventName) => {
        this.textarea.addEventListener(eventName, this.refreshLine.bind(this))
      })
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

    handleInput() {
      this.refreshLine()
      this.makeHistory()
    },

    refreshLine() {
      const { value, selectionStart, selectionEnd } = this.textarea
      this.lines = value.split('\n')
      this.activeLineNumber =
        selectionStart === selectionEnd
          ? String(value).slice(0, selectionStart).split('\n').length - 1
          : -1
      this.activeLine = this.lines[this.activeLineNumber]
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
          const { value, selectionStart, selectionEnd } =
            this.history[this.position]
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
          const { value, selectionStart, selectionEnd } =
            this.history[this.position]
          this.textarea.value = value
          this.setSelection(selectionStart, selectionEnd)
        }
      } else {
        const { start, end, defaultText } = this.commandMap[command]
        selectedText = selectedText || defaultText || ''
        this.textarea.value = startText + start + selectedText + end + endText
        this.setSelection(
          selectionStart + start.length,
          selectionStart + start.length + selectedText.length,
        )
        this.textarea.dispatchEvent(new Event('input'))
      }
    },
  }))
})
