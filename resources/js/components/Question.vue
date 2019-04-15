<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title">
                    </div>

                    <hr>

                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div class="form-group">
                                <textarea v-model="body" rows="10" class="form-control" required></textarea>
                            </div>
                            <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                            <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
                        </div>
                    </div>
                </form>
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <a :href="questionsUrl" class="btn btn-outline-secondary">Back to all Questions</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('modify', question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">
                                            Edit
                                        </a>
                                        <button v-if="authorize('deleteQuestion', question)" @click="remove" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info v-bind:model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
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
        props: ['question'],

        mixins: [modification],

        computed: {
            questionsUrl () {
                return '/questions';
            },

            isInvalid () {
                return this.body.length < 10 || this.title.length < 10;
            },

            updateEndpoint () {
                return `/questions/${this.id}/update`;
            },

            deleteEndpoint () {
                return `/questions/${this.id}/destroy`;
            }
        },

        data () {
            return {
                title: this.question.title,
                body: this.question.body,
                bodyHtml: this.question.body_html,
                id: this.question.id,
                beforeEditCache: {}
            }
        },

        methods: {
            setEditCache () {
                this.beforeEditCache = {
                    title: this.title,
                    body: this.body
                };
            },

            restoreFromCache () {
                this.title = this.beforeEditCache.title;
                this.body = this.beforeEditCache.body;
            },

            payload () {
                return {
                    title: this.title,
                    body: this.body
                }
            },

            delete () {
                axios.post(this.deleteEndpoint)
                    .then(({data}) => {
                        this.$toast.success(data.message, 'Success', {
                            timeout: 2000
                        });
                    });

                setTimeout(() => {
                    window.location.href = this.questionsUrl;
                }, 3000);
            }
        },

        components: {
            Vote: Vote,
            UserInfo: UserInfo
        }
    }
</script>

<style scoped>

</style>