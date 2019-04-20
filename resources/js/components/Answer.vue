<template>
    <div class="media post">
        <vote :model="answer" name="answer"></vote>
        <div class="media-body">
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update">
                <div class="form-group">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea v-model="body" rows="10" class="form-control" required></textarea>
                    </m-editor>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-show="!editing">
                <div v-html="bodyHtml" ref="bodyHtml"></div>
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
    import modification from '../mixins/modifications';

    export default {
        props: ['answer'],

        mixins: [modification],

        computed: {
            isInvalid () {
                return this.body.length < 10;
            },

            destroyEndpoint () {
                return this.buildEndpoint('destroy');
            },

            updateEndpoint () {
                return this.buildEndpoint('update');
            },

            uniqueName () {
                return `answer-${this.id}`;
            },
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
                axios.post(this.destroyEndpoint)
                    .then((resp) => {
                        this.$toast.success(resp.message, 'Success', {
                            timeout: 2000
                        });
                        this.$emit('deleted');
                    });
            },

            buildEndpoint (method) {
                return `/questions/${this.questionId}/answers/${this.id}/${method}`;
            },
        }
    }
</script>