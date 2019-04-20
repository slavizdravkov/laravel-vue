import Vote from '../components/Vote';
import UserInfo from '../components/UserInfo';
import MEditor from '../components/MEditor';

import highlight from './highlight';

export default {
    mixins: [highlight],

    components: {
        Vote: Vote,
        UserInfo: UserInfo,
        MEditor: MEditor
    },

    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },

        cancel () {
            this.restoreFromCache();
            this.editing = false;
        },

        setEditCache () {},
        restoreFromCache () {},

        update () {
            axios.post(this.updateEndpoint, this.payload())
                .catch(({data}) => {
                    this.$toast.error(data.message, 'Error', {
                        timeout: 3000
                    })
                })
                .then(({data}) => {
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, 'Success', {
                        timeout: 3000
                    });
                    this.editing = false;
                })
                .then(() => this.highlight());
        },

        payload () {},

        remove () {
            this.$toast.question('Are you sure about that?', 'Confirm', {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', (instance, toast) => {
                        this.delete();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
            });
        },

        delete () {}
    }
}