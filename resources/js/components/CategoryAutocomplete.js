export default {
  props: ['categories'],
  mounted() {
    const input = this.$refs.input;
    const autoCompletejs = new window.autoComplete({
      data: {
        src: () => {
          return this.categories
        },
        key: ["name"],
        cache: false
      },
      sort: (a, b) => {
        if (a.match < b.match) return -1;
        if (a.match > b.match) return 1;
        return 0;
      },
      selector: "#autoComplete",
      threshold: 0,
      debounce: 0,
      searchEngine: "strict",
      highlight: true,
      maxResults: 5,
      resultsList: {
        render: true,
        destination: input,
        position: "afterend",
        element: "ul"
      },
      resultItem: {
        content: (data, source) => {
          source.innerHTML = data.match;
        },
        element: "li"
      },
      onSelection: feedback => {
        const selection = feedback.selection.value.name;
        this.$refs.input.value = selection
        setTimeout(() => {
          input.focus()
        }, 50)
      }
    });
  }
}
