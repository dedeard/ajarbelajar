<template>
  <draggable
    class="list-group list-group-bordered video-list"
    tag="ul"
    handle=".handle"
    v-model="list"
    v-bind="dragOptions"
    v-if="videos"
    draggable=".list-group-item"
  >
    <li class="list-group-item" v-for="video in list" :key="video.index">
      <div class="wrapper">
        <span class="handle">:::</span>
        <video-order-player :video="video" @videodeleted="handleDelete" :thumb="thumb"></video-order-player>
      </div>
    </li>
    <div slot="footer" key="footer">
      <input type="text" name="index" :value="index" class="d-none">
      <video-uploader :upload-url="uploadUrl" @newvideo="handleNew"></video-uploader>
    </div>
  </draggable>
</template>

<script>
import draggable from "vuedraggable";
import VideoOrderPlayer from './VideoOrderPlayer'
import VideoUploader from './VideoUploader'

export default {
  props: ['videos', 'upload-url', 'thumb'],
  components: {
    draggable,
    VideoOrderPlayer,
    VideoUploader
  },
  data() {
    return {
      list: null
    }
  },
  methods: {
    handleNew(data) {
      this.list = [
        ...this.list,
        data
      ]
    },
    handleDelete(data) {
      const list = []
      this.list.forEach((el) => {
        if(el.id !== data.id) {
          list.push(el);
        }
        console.log(el.id, data.id)
      })
      this.list = list
    }
  },
  computed: {
    index() {
      const index = []
      if(this.list) {
        this.list.forEach(el => {
          index.push(el.id)
        })
      }
      return index.join('|')
    },
    dragOptions() {
      return {
        animation: 200,
        disabled: false,
        ghostClass: "ghost"
      };
    }
  },
  mounted() {
    this.list = this.videos
  }
};
</script>



<style lang="scss">
  @import "resources/sass/_vars.scss";
  .video-list {
    .flip-list-move {
      transition: transform 0.5s;
    }
    .no-move {
      transition: transform 0s;
    }
    .ghost {
      opacity: 0.5;
    }

    .list-group-item {
      padding: 0 !important;
      user-select: none;

      .wrapper {
        display: flex;
      }

      .handle {
        cursor: grab;
        display: block;
        width: 40px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        font-size: 20px;
        letter-spacing: 1px;
        color: $gray-700;
        font-weight: $font-weight-bold;
        margin: auto 0;
      }
      .sortable-chosen {
        .handle {
          cursor: grabbing;
        }
      }

    }
  }
</style>
