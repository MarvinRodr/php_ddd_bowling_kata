<template>
    <div class="row">
        <div class="col-md-2">
            <strong>Player:</strong> {{player.name}}
            <template v-if="launches.length < maxNumFrame">
                <button type="button" @click="launch" class="btn btn-success">Launch with luck!</button>
                <button type="button" @click="launch('strike')" class="btn btn-danger">Make a strike!</button>
                <button type="button" @click="launch('spare')" class="btn btn-warning">Make a spare!</button>
            </template>
            <template v-else>
                No more tries!
            </template>
        </div>
        <div class="col-md-7">
            <div class="row row-cols-auto">
                <template v-for="(launch, key) in launches" :key="key">
                    <div :class="launchClasses(launch)">{{launch.first_one}} - {{ launch.second_one }}</div>
                </template>
            </div>
        </div>
        <div class="col-md-1">
            <strong>Score:</strong> {{totalScore}}
        </div>
        <div class="col-md-2">
            <button type="button" @click="getScore" class="btn btn-info">Show score!</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "BowlingLane",
    props: {
        player: Object,
    },
    data() {
        return {
            launches: [],
            totalScore: 0,
            maxNumFrame: 12,
        }
    },
    methods: {
        getScore() {
            fetch(`http://localhost:8040/api/player/${this.player.id}/score`)
            .then((r) => r.json())
            .then((r) => this.totalScore = r.total_score)
        },
        launch(type) {
            let payload = null;
            switch (type) {
                case 'strike':
                    payload = this.getStrikePayload()
                    break;

                case 'spare':
                    payload = this.getSparePayload()
                    break;

                case 'bonus':
                    payload = this.getBonusPayload()
                    break;

                default:
                    payload = this.getLaunchPayload()
                    break;
            }
            fetch(
                "http://localhost:8040/api/player/launch",
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }
            )
            .then((r) => r.json())
            .then((r) => {
                this.launches.push(r)
                this.getScore()
            })
        },
        payload(firstOne, secondOne) {
            return {
                id: null,
                player_id: this.player.id,
                first_one: firstOne,
                second_one: secondOne,
                num_frame: this.launches.length + 1,
            }
        },
        getLaunchPayload() {
            let firstOne = this.getRandomNumber(0, 10)
            let secondOne = firstOne < 10 ? this.getRandomNumber(0, 10 - firstOne) : 0
            return this.payload(firstOne, secondOne)
        },
        getStrikePayload() {
            return this.payload(10, 0)
        },
        getSparePayload() {
            return this.payload(0, 10)
        },
        getBonusPayload() {
            let firstOne = this.getRandomNumber(0, 10)
            let secondOne = firstOne === 10 ? this.getRandomNumber(0, 10 - firstOne) : 0
            return this.payload(firstOne, secondOne)
        },
        getRandomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) ) + min;
        },
        launchClasses(launch) {
            return {
                col: true,
                'bg-warning': launch.is_spare,
                'bg-danger': launch.is_strike,
            }
        },
    }
}
</script>

<style scoped>

</style>