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
            console.log(el);
            Prism.highlightAllUnder(el);
        }
    }
}