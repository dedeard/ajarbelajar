import EditorJS from '@editorjs/editorjs'
import Paragraph from '@editorjs/paragraph'
import List from '@editorjs/list'
import CodeTool from '@editorjs/code'
import InlineCode from '@editorjs/inline-code'

window.initEditor = ({ holder, value = '', onChange = null } = {}) => {
  let data
  try {
    data = JSON.parse(value || '')
  } catch (e) {
    console.error('Error parsing JSON:', e)
  }
  const editor = new EditorJS({
    holder,
    async onChange() {
      try {
        if (typeof onChange === 'function') {
          await onChange(JSON.stringify(await editor.save()))
        }
      } catch (err) {
        console.error('Editor.js error:', err)
      }
    },
    data,
    autofocus: false,
    minHeight: 150,
    tools: {
      paragraph: { class: Paragraph, inlineToolbar: true },
      list: { class: List, inlineToolbar: true },
      code: CodeTool,
      inlineCode: InlineCode,
    },
  })
  return editor
}
