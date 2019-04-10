<template>
    <a
        title="Click to mark as favorite question (Click again to undo)"
        :class="classes"
        @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>

<script>
    export default {
        props: ['question'],

        data () {
            return {
                isFavorited: this.question.is_favorited,
                count: this.question.favorites_count,
                id: this.question.id
            }
        },

        computed: {
            classes () {
                let dynamicClassName = !this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '');

                return [
                    'favorite',
                    'mt-2',
                    dynamicClassName
                ];
            },

            endpoint () {
                return this.isFavorited ? `/questions/${this.id}/unfavorite` : `/questions/${this.id}/favorite`
            }
        },

        methods: {
            toggle () {
                if (!this.signedIn) {
                    this.$toast.warning('Please login to favorite this question', 'Warning', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                }
                this.isFavorited ? this.destroy() : this.create();
            },

            destroy () {
                axios.post(this.endpoint)
                .then(response => {
                    this.count--;
                    this.isFavorited = false;
                });
            },

            create () {
                axios.post(this.endpoint)
                .then(response => {
                    this.count++;
                    this.isFavorited = true;
                });
            }
        }
    }
</script>

<style scoped>

</style>