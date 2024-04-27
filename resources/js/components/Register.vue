<template>
    <div>
        {{ countDown }}
        <button @click="play">Play</button>
        <button @click="paupse">Pause</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            timerEnabled: true,
            countDown: 10,
        };
    },
    watch: {
        timerEnabled(value) {
            if (value) {
                setTimeout(() => {
                    this.countDown--;
                }, 1000);
            }
        },
        countDown: {
            handler(value) {
                if (value > 0 && this.timerEnabled) {
                    setTimeout(() => {
                        this.countDown--;
                    }, 1000);
                }
            },
            immediate: true,
        },
    },
    methods: {
        play() {
            this.timerEnabled = true;
        },
        pause() {
            this.timerEnabled = false;
        },
    },
};
</script>
