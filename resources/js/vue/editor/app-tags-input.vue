<template>
  <div>
    <vue-tags-input
      v-model="tag"
      :tags="tagsIn"
      @tags-changed="changed"
    />
    <input type="hidden" :name="name" :value="strTags">
  </div>
</template>

<script>
import VueTagsInput from '../vendors/vue-tags-input/vue-tags-input.vue';

export default {
  props: ['tags', 'name'],
  components: {
    VueTagsInput,
  },
  data() {
    return {
      tag: '',
      tagsIn: [],
    };
  },
  computed: {
    strTags(){
      const tags = []
      this.tagsIn.forEach(tag => {
        tags.push(tag.text)
      })
      return tags.join(',')
    }
  },
  methods: {
    changed(newTag){
      this.tagsIn = newTag
    }
  },
  mounted(){
    this.tags.forEach(tag => {
      this.tagsIn.push({ text: tag.name })
    })
  }
};
</script>