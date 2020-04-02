import EditorJS from '@editorjs/editorjs'
import Image from '@editorjs/image'
import Header from '@editorjs/header'
import List from '@editorjs/list'
import Checklist from '@editorjs/checklist'
import Quote from '@editorjs/quote'
import Warning from '@editorjs/warning'
import Marker from '@editorjs/marker'
import CodeTool from '@editorjs/code'
import Delimiter from '@editorjs/delimiter'
import InlineCode from '@editorjs/inline-code'
import LinkTool from '@editorjs/link'
import Embed from '@editorjs/embed'
import Table from '@editorjs/table'
import FromData from 'form-data'

const editor = new EditorJS({
  holder: document.getElementById('codex-editor'),
  autofocus: true,
  minHeight: 300,
  tools: {
    image: {
      class: Image,
      config: {
        uploader: {
          uploadByFile(file){
            var data = new FromData;
            data.append('file', file);
            const url = document.getElementById('codex-editor').getAttribute('image-url');
            return axios.post(url, data).then((response) => {
              return response.data
            })
          }
        }
      }
    },
    header: {
      class: Header,
      inlineToolbar: ['link'],
      config: {
        placeholder: 'Header'
      },
      shortcut: 'CMD+SHIFT+H'
    },
    list: {
      class: List,
      inlineToolbar: true,
      shortcut: 'CMD+SHIFT+L'
    },
    checklist: {
      class: Checklist,
      inlineToolbar: true,
    },
    quote: {
      class: Quote,
      inlineToolbar: true,
      config: {
        quotePlaceholder: 'Enter a quote',
        captionPlaceholder: 'Quote\'s author',
      },
      shortcut: 'CMD+SHIFT+O'
    },
    warning: Warning,
    marker: {
      class:  Marker,
      shortcut: 'CMD+SHIFT+M'
    },
    code: {
      class:  CodeTool,
      shortcut: 'CMD+SHIFT+C'
    },
    delimiter: Delimiter,
    inlineCode: {
      class: InlineCode,
      shortcut: 'CMD+SHIFT+C'
    },
    linkTool: LinkTool,
    embed: Embed,
    table: {
      class: Table,
      inlineToolbar: true,
      shortcut: 'CMD+ALT+T'
    },
  },
  data: document.getElementById('post-editor').value ? JSON.parse(document.getElementById('post-editor').value) : '',
  async onChange() {
    try {
      document.getElementById('post-editor').value = JSON.stringify(await editor.save())
    } catch(e) {
      console.log(e)
    }
  }
})

$(document).ready(function(){
  $('#button-save').click(async function(e){
    e.preventDefault()
    try {
      document.getElementById('post-editor').value = JSON.stringify(await editor.save())
    } catch(e) {
      console.log(e)
    }
    $(this).parents('form').submit()
  })
})