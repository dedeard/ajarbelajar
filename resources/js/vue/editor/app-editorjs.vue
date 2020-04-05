<template>
  <div>
    <div ref="editorjs"></div>
    <textarea name="body" class="d-none">{{ saved }}</textarea>
  </div>
</template>

<script>
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

export default {
  props: ['image-url', 'editor-body'],
  data() {
    return {
      body: null,
      editor: null,
      holder: null
    }
  },
  computed: {
    saved(){
      return JSON.stringify(this.body)
    }
  },
  mounted(){
    const self = this
    this.holder = this.$refs.editorjs
    this.body = this.editorBody ? JSON.parse(this.editorBody) : {};

    this.editor = new EditorJS({
      holder: this.holder,
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
                const url = self.imageUrl
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
      data: self.editorBody ? JSON.parse(self.editorBody) : '',
      async onChange() {
        try {
          self.body = await self.editor.save()
        } catch(e) {
          console.log(e)
        }
      }
    })
  }
}
</script>