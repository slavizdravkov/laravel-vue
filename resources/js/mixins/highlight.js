import Prism from 'prismjs';

export default {
    methods: {
        highlight (id = '') {
            let el;
            if (id) {
                el = document.getElementById(id);
            } else {
                el = this.$refs.bodyHtml;
            }

            Prism.highlightAllUnder(el);
        }
    }
}