<template>

    <VueLoading
        v-model:active="isLoading"
         :is-full-page="fullPage"
    />

    <div class="row">
        <div class="col-md-2">
            <strong>Player:</strong> {{player.name}}
            <template v-if="showBonusLaunch() === true">
                <button type="button" @click="makeLastLaunch" class="btn btn-info">Lucky last launch!</button>
                <button type="button" @click="makeLastLaunch('last-launch-all-strike')" class="btn btn-warning">Make all strikes!</button>
            </template>
            <template v-else-if="launches.length < maxNumFrame">
                <button type="button" @click="launch" class="btn btn-success">Lucky launch!</button>
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
                    <div :class="launchClasses(launch)" v-html="launchHtml(launch)"></div>
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
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

export default {
    name: "BowlingLane",
    components: {VueLoading},
    props: {
        player: Object,
    },
    data() {
        return {
            launches: [],
            totalScore: 0,
            maxNumFrame: 10,
            maxNumPinsCanBeKnocked: 10,
            payload: null,
            isLoading: false,
            fullPage: true,
        }
    },
    methods: {
        getScore() {
            this.isLoading = true
            fetch(`http://localhost:8040/api/player/${this.player.id}/score`)
            .then((r) => r.json())
            .then((r) => {
                this.totalScore = r.total_score
                this.isLoading = false
            })
        },
        launch(type) {
            this.isLoading = true
            switch (type) {
                case 'strike':
                    this.payload = this.getStrikePayload()
                    break;

                case 'spare':
                    this.payload = this.getSparePayload()
                    break;

                default:
                    this.payload = this.getLaunchPayload()
                    break;
            }

            this.makeRequest()
        },
        makeRequest() {
            fetch(
                "http://localhost:8040/api/player/launch",
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.payload)
                }
            )
            .then((r) => r.json())
            .then((r) => {
                this.launches.push(r)
                this.getScore()
                this.isLoading = false
            })
        },
        makeLastLaunch(type) {
            switch (type) {
                case 'last-launch-all-strike':
                    this.payload = this.composePayload(this.maxNumPinsCanBeKnocked, this.maxNumPinsCanBeKnocked, this.maxNumPinsCanBeKnocked)
                    break;
                default:
                    this.payload = this.getLastLaunchPayload()
                    break;
            }
            this.makeRequest()
        },
        composePayload(firstOne, secondOne, thirdOne) {
            return {
                id: null,
                player_id: this.player.id,
                first_one: firstOne,
                second_one: secondOne,
                third_one: thirdOne,
                num_frame: this.launches.length < this.maxNumFrame ? this.launches.length + 1: this.maxNumFrame,
            }
        },
        getLaunchPayload() {
            let firstOne = this.getRandomNumber(0, this.maxNumPinsCanBeKnocked)
            let secondOne = firstOne < this.maxNumPinsCanBeKnocked ? this.getRandomNumber(0, this.maxNumPinsCanBeKnocked - firstOne) : 0
            let thirdOne = 0
            return this.composePayload(firstOne, secondOne, thirdOne)
        },
        getLastLaunchPayload() {
            let firstOne = this.getRandomNumber(0, this.maxNumPinsCanBeKnocked)
            let secondOne = 0
            let thirdOne = 0
            if (firstOne === this.maxNumPinsCanBeKnocked) {
                secondOne = this.getRandomNumber(0, this.maxNumPinsCanBeKnocked)
                if (secondOne === this.maxNumPinsCanBeKnocked) {
                    thirdOne = this.getRandomNumber(0, this.maxNumPinsCanBeKnocked)
                }
            } else {
                secondOne = firstOne < this.maxNumPinsCanBeKnocked ? this.getRandomNumber(0, this.maxNumPinsCanBeKnocked - firstOne) : 0
            }

            return this.composePayload(firstOne, secondOne, thirdOne)
        },
        getStrikePayload() {
            return this.composePayload(this.maxNumPinsCanBeKnocked, 0, 0)
        },
        getSparePayload() {
            return this.composePayload(0, this.maxNumPinsCanBeKnocked, 0)
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
        showBonusLaunch() {
            let lastLaunch = this.launches.at(-1)

            return (lastLaunch)
                && (this.launches.length === this.maxNumFrame)
                && (lastLaunch.first_one === this.maxNumPinsCanBeKnocked)
        },
        launchHtml(launch) {
            let first = launch.first_one ? (launch.first_one === this.maxNumPinsCanBeKnocked ? 'X' : launch.first_one) : ''
            let second = launch.second_one ? ' - ' + (launch.second_one === this.maxNumPinsCanBeKnocked ? 'X' : launch.second_one) : ''
            let third = launch.third_one ? ' - ' + (launch.third_one === this.maxNumPinsCanBeKnocked ? 'X' : launch.third_one) : ''
            let launchHtml = first + second + third
            return `<span> ${launchHtml} </span>`
        }
    }
}
</script>

<style scoped>

</style>