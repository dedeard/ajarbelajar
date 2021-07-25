import EditorJS from '@editorjs/editorjs'
import Image from '@editorjs/image'
import Header from '@editorjs/header'
import List from '@editorjs/list'
import Quote from '@editorjs/quote'
import Marker from '@editorjs/marker'
import CodeTool from '@editorjs/code'
import Delimiter from '@editorjs/delimiter'
import InlineCode from '@editorjs/inline-code'
import LinkTool from '@editorjs/link'
import Table from 'editorjs-table'
import FormData from 'form-data'

window.initEditor = (id, target, uploadUrl) => {
  const value = $('#' + target).val()
  const editor = new EditorJS({
    holder: document.getElementById(id),
    autofocus: true,
    minHeight: 300,
    tools: {
      image: {
        class: Image,
        inlineToolbar: true,
        config: {
          uploader: {
            uploadByFile(file) {
              const data = new FormData()
              data.append('file', file)
              return window.axios.post(uploadUrl, data).then((response) => {
                return response.data
              })
            },
          },
        },
      },
      header: {
        class: Header,
        inlineToolbar: ['link'],
        config: {
          placeholder: 'Header',
        },
        shortcut: 'CMD+SHIFT+H',
      },
      list: {
        class: List,
        inlineToolbar: true,
        shortcut: 'CMD+SHIFT+L',
      },
      quote: {
        class: Quote,
        inlineToolbar: true,
        config: {
          quotePlaceholder: 'Enter a quote',
          captionPlaceholder: "Quote's author",
        },
        shortcut: 'CMD+SHIFT+O',
      },
      marker: {
        class: Marker,
        shortcut: 'CMD+SHIFT+M',
      },
      code: {
        class: CodeTool,
        shortcut: 'CMD+SHIFT+C',
      },
      delimiter: Delimiter,
      inlineCode: {
        class: InlineCode,
        shortcut: 'CMD+SHIFT+C',
      },
      linkTool: LinkTool,
      table: {
        class: Table,
        inlineToolbar: true,
        config: {
          rows: 2,
          cols: 3,
        },
        shortcut: 'CMD+ALT+T',
      },
    },
    data: value ? JSON.parse(value) : '',
    async onChange() {
      try {
        $('#' + target).val(JSON.stringify(await editor.save()))
        console.log('input', JSON.stringify(await editor.save()))
      } catch (e) {
        console.log('Editor.js error', e)
      }
    },
  })
  return editor
}
