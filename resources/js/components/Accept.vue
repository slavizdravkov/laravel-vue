<template>
    <div>
        <a
            v-if="canAccept"
            title="Make this answer as best answer"
            :class="classes"
            @click.prevent="create"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>

        <a
            v-if="accepted"
            title="The question owner accepted this answer as best answer"
            :class="classes"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['answer'],

        data () {
            return {
                isBest: this.answer.is_best,
                id: this.answer.id
            }
        },

        computed: {
            canAccept () {
                return this.authorize('accept', this.answer);
            },

            accepted () {
                return !this.canAccept && this.isBest;
            },

            classes () {
                let dynamicClassName = this.isBest ? 'vote-accepted' : '';

                return [
                    'mt-2',
                    dynamicClassName
                ];
            }
        },

        methods: {
            create () {
                axios.post(`/answers/${this.id}/accept`)
                .then(response => {
                    this.$toast.success(response.data.message, 'Success', {
                        timeout: 3000,
                        position: 'topRight'
                    });

                    this.isBest = true;
                });
            }
        }
    }
</script>

<style scoped>

</style>