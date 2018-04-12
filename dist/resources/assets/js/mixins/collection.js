'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  data: function data() {
    return {
      items: []
    };
  },


  methods: {
    remove: function remove(index) {
      this.items.splice(index, 1);
      this.$emit('removed');
    },
    add: function add(item) {
      this.items.push(item);
      this.$emit('added');
    }
  }

};
//# sourceMappingURL=collection.js.map