<template>
    <div class="d-flex flex-column vote-controls">
        <a
            @click.prevent="voteUp"
            :title="titles('up')"
            class="vote-up" :class="classes"
        >
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a
            @click.prevent="voteDown"
            :title="titles('down')"
            class="vote-down" :class="classes"
        >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name === 'question'" v-bind:question="model"></favorite>
        <accept v-else v-bind:answer="model"></accept>
    </div>
</template>

<script>
    import Favorite from './Favorite';
    import Accept from './Accept';
    export default {
        props: ['name', 'model'],

        computed: {
            classes () {
                return this.signedIn ? '' : 'off';
            },

            endpoint () {
                return `/${this.name}s/${this.id}/vote`
            }
        },

        components: {
            Favorite: Favorite,
            Accept: Accept
        },

        data () {
            return {
                count: this.model.votes_count,
                id: this.model.id
            }
        },

        methods: {
            titles (voteType) {
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is not useful`
                };

                return titles[voteType];
            },

            voteUp () {
                this._vote(1);
            },

            voteDown () {
                this._vote(-1);
            },

            _vote (vote) {
                if (!this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${this.name}`, 'Warning', {
                        timeout: 3000,
                        position: 'topRight'
                    })
                }
                axios.post(this.endpoint, {
                    vote: vote
                })
                .then(resp => {
                    this.$toast.success(resp.data.message, 'Success', {
                        timeout: 3000,
                        position: 'topRight'
                    });

                    this.count = resp.data.votesCount;
                })
            }
        }
    }
</script>

<style scoped>

</style>