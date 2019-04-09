<script>
    export default {
        props: ['answer'],

        computed: {
            isInvalid () {
                return this.body.length < 10;
            }
        },

        data () {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            }
        },

        methods: {
            edit () {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel () {
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            update () {
                axios.post(`/questions/${this.questionId}/answers/${this.id}/update`, {
                    body: this.body
                })
                .then(response => {
                    this.editing = false;
                    this.bodyHtml = response.data.body_html;
                    alert(response.data.message);
                })
                .catch(error => {
                    alert(error.response.data.message)
                });
            }
        }
    }
</script>