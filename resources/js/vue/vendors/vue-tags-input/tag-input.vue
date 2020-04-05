<!-- A helper component used by VueTagsInput and can be put into the tag-center slot -->

<template>
  <input
    v-if="scope.edit"
    v-model="scope.tag.text"
    :maxlength="scope.maxlength"
    type="text"
    class="ti-tag-input"
    size="1"
    @input="scope.validateTag(scope.index, $event)"
    @blur="scope.performCancelEdit(scope.index)"
    @keydown="scope.performSaveEdit(scope.index, $event)"
  >
</template>

<script>

export default {
  name: 'TagInput',
  props: {
    scope: {
      type: Object,
    },
  },
};

</script>