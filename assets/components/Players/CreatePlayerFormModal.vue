<template>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#playerCreateModal" data-bs-whatever="@mdo">Create a player!</button>
    <div class="modal fade" id="playerCreateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Enter your name, player!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="player-name" class="col-form-label">You name:</label>
                        <input type="text" @keyup.enter="create" v-model="newPlayer.name" class="form-control" id="player-name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="create" class="btn btn-primary" data-bs-dismiss="modal">Create!</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CreatePlayerFormModal",
    data() {
        return {
            newPlayer: {
                id: null,
                name: ''
            }
        }
    },
    methods: {
        create() {
            if (this.newPlayer.name === null && this.newPlayer.name === '') {
                return;
            }
            fetch(
                "http://localhost:8040/api/player",
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.newPlayer)
                }
            )
            .then((r) => r.json())
            .then((r) => {
                this.newPlayer = r
                this.addPlayer()
            })

        },
        addPlayer() {
            this.$emit('add-player', this.newPlayer)
            this.reset()
        },
        reset() {
            this.newPlayer = {
                id: null,
                name: ''
            }
        }
    }
}
</script>

<style scoped>

</style>