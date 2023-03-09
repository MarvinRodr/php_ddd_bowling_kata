import './styles/app.css';
import { createApp } from 'vue'

createApp({
    data() {
        return {
            count: 0
        }
    },
    template: '<h1>Hello Bowling Challenge!</h1>'
}).mount('#app')