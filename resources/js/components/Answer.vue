<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea v-model="body" rows="10" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">
                                Edit
                            </a>
                            <button v-if="authorize('modify', answer)" @click="remove" class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </div>
                    </div>

                    <div class="col-4"></div>

                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vote from './Vote';
    import UserInfo from './UserInfo';
    import modification from '../mixins/modifications';

    export default {
        props: ['answer'],

        mixins: [modification],

        computed: {
            isInvalid () {
                return this.body.length < 10;
            },

            answersEndpointBase () {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },

        data () {
            return {
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            }
        },

        methods: {
            setEditCache () {
                this.beforeEditCache = this.body;
            },

            restoreFromCache () {
                this.body = this.beforeEditCache;
            },

            payload () {
                return {
                    body: this.body
                };
            },

            delete () {
                axios.post(`${this.answersEndpointBase}/destroy`)
                    .then(resp => {
                        this.$toast.success(resp.message, 'Success', {
                            timeout: 2000
                        });
                        this.$emit('deleted');
                    });
            }
        },

        components: {
            Vote: Vote,
            UserInfo: UserInfo
        }
    }
</script>