import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header'
import Paragraph from '@editorjs/paragraph'
import List from '@editorjs/list'
import Quote from '@editorjs/quote'
import CodeTool from '@editorjs/code'
import Delimiter from '@editorjs/delimiter'
import InlineCode from '@editorjs/inline-code'
import Underline from '@editorjs/underline'
import Table from 'editorjs-table'
// import FormData from 'form-data'

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
      header: { class: Header, inlineToolbar: true },
      paragraph: { class: Paragraph, inlineToolbar: true },
      list: { class: List, inlineToolbar: true },
      quote: { class: Quote, inlineToolbar: true },
      table: { class: Table, inlineToolbar: true },
      code: CodeTool,
      delimiter: Delimiter,
      inlineCode: InlineCode,
      underline: Underline,
    },
  })
  return editor
}
