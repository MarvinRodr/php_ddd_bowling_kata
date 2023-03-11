<template>
    <div class="container text-center">
        <h1>Welcome to the Bowling Challenge!</h1>
        <template v-for="(player, key) in players" :key="key">
            <BowlingLane :player="player"></BowlingLane>
        </template>
        <hr>
        <CreateFormModal @add-player="addPlayer"></CreateFormModal>
    </div>
</template>

<script>
import CreateFormModal from "../../components/Players/CreatePlayerFormModal";
import BowlingLane from "../../components/BowlingLane";

export default {
    name: "Home",
    components: {BowlingLane, CreateFormModal},
    data() {
        return {
            players: [],
        }
    },
    methods: {
        addPlayer(newPlayer) {
            this.players.push(newPlayer)
        },
    },
}
</script>

<style scoped>

</style>